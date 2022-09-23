<?php
class ModelToolImage extends Model {


	public function resize_webp($filename, $width, $height) {
		$this->resize($filename, $width, $height, true);
	}

	public function resize_avif($filename, $width, $height) {
		$this->resize($filename, $width, $height, false, true);
	}

	public function resize($filename, $width, $height, $webp_explicit = false, $avif_explicit = false) {
		if (!is_file(DIR_IMAGE . $filename)) {
			if (is_file(DIR_IMAGE . 'no_image.jpg')) {
				$filename = 'no_image.jpg';
			} elseif (is_file(DIR_IMAGE . 'no_image.png')) {
				$filename = 'no_image.png';
			} else {
				return;
			}
		}

		$uri = '';
		if (isset($this->request->server['REQUEST_URI'])) {
			$uri = $this->request->server['REQUEST_URI'];
		}

		$webp = false;
		$avif = false;

		if (stripos($uri, 'admin') === false) {
			if (isset($this->request->server['HTTP_ACCEPT']) && isset($this->request->server['HTTP_USER_AGENT'])) {
				if( strpos( $this->request->server['HTTP_ACCEPT'], 'image/webp' ) !== false ) {	
					$webp = true;	
				}

				if( strpos( $this->request->server['HTTP_ACCEPT'], 'image/avif' ) !== false ) {	
					$avif = true;	
				}
			}
		}

		if ($webp_explicit){
			$webp = true;	
		}

		if ($avif_explicit){
			$avif = true;	
		}

		$info = pathinfo($filename);
		$extension = $info['extension'];
		$basename = $info['basename'];
		$dirname = $info['dirname'];


		if ($webp){
			$extension = 'webp';
		}

		if ($avif){
			$extension = 'avif';
		}

		$old_image = $filename;

		$new_image_struct = Image::cachedname($filename, $extension, array($width, $height, IMAGE_QUALITY));
		$new_image = $new_image_struct['full_path'];
		$new_image_relative = $new_image_struct['relative_path'];


		if (!file_exists($new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime($new_image))) {				
			$image = new Image(DIR_IMAGE . $old_image);

			$image->resize($width, $height);

			if ($avif){
				$image->saveavif($new_image, IMAGE_QUALITY);
			} elseif ($webp){
				$image->savewebp($new_image, IMAGE_QUALITY);	
			} else {
				$image->save($new_image, IMAGE_QUALITY);	
			}
		}

		$img_server = $this->config->get('config_ssl');

		if (defined('HTTPS_IMG_SERVER')){
				//подмена сервера на img_url - первый шард-сервер, если он существует
			$img_server = HTTPS_IMG_SERVER;
		}

		if (defined('HTTPS_IMG_SERVERMASK') && defined('HTTPS_IMG_SERVERCOUNT')){
				//У нас существует несколько дополнительных шард-серверов
			$img_server = str_replace('{N}', (ord($basename) % (HTTPS_IMG_SERVERCOUNT+1)), HTTPS_IMG_SERVERMASK); 
		}

		return $img_server . $new_image_relative;
	}
}
