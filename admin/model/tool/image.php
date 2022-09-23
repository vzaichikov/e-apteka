<?php
	class ModelToolImage extends Model {
		public function resize($filename, $width, $height, $quality = 80) {
			if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != DIR_IMAGE) {
				return;
			}
			
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			
			$image_old = $filename;			
			$old_image = $filename;
			$image_new_struct = Image::cachedname($filename, $extension, [$width, $height, $quality, false, false]);
			
			$image_new = $image_new_struct['full_path'];
			$image_new_relative = $image_new_struct['relative_path'];
			
			if (!file_exists($image_new) || (filemtime(DIR_IMAGE . $old_image) > filemtime($image_new))) {								
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save($image_new, $quality);	
			}
			
			return HTTPS_CATALOG . $image_new_relative;			
		}
	}
