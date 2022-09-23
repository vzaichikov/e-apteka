<?php
class Image {
    private $file;
    private $image;
    private $width;
    private $height;
    private $bits;
    private $mime;

    public function __construct($file) {
        if (is_file($file)) {
            $this->file     = $file;

            try {  

                $this->image    = new Imagick($file);
                $this->width    = $this->image->getImageWidth();
                $this->height   = $this->image->getImageHeight();
                $this->bits     = $this->image->getImageLength();
                $this->mime     = $this->image->getFormat();

            } catch (Exception $e) {
                echo $e->getMessage();
            }

        } else {           
        }
    }

    public static function cachedname($filename, $extension, $data = array()){
        $md5 = md5($filename . implode('.', $data));

        $directory              = DIR_IMAGECACHE . substr($md5, 0, 5) . '/';
        $image_name             = $md5 . 'x' . $data[0] . 'x' . $data[1] . 'x' . $data[2] .  '.' . $extension;
        $full_image_path        = $directory . $image_name;
        $relative_image_path    = DIR_IMAGECACHE_NAME . substr($md5, 0, 5) . '/' . $image_name;

        if (!is_dir($directory)){
            mkdir($directory, 0775, true);
        }

        return ['full_path' => $full_image_path, 'relative_path' => $relative_image_path];
    }



    public function getFile() {
        return $this->file;
    }

    public function getImage() {
        return $this->image;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getBits() {
        return $this->bits;
    }

    public function getMime() {
        return $this->mime;
    }

    public function saveavif($file, $quality = IMAGE_QUALITY) {
        $this->image->setImageFormat('avif');
        $this->save($file, $quality = IMAGE_QUALITY);
    }

    public function savewebp($file, $quality = IMAGE_QUALITY) {
        $this->image->setImageFormat('webp');
        $this->save($file, $quality = IMAGE_QUALITY);
    }

    public function save($file, $quality = IMAGE_QUALITY) {                
        $this->image->setCompressionQuality($quality);
        $this->image->writeImage($file);
    }

    public function resize($width = 0, $height = 0, $default = '') {
        if (!$this->width || !$this->height) {
            return;
        }

        $this->image->thumbnailImage($width, $height, true, true);
        $this->width    = $width;
        $this->height   = $height;
    }


    public function watermark($watermark, $position = 'bottomright') {
        $watermark_pos_x = 0;
        $watermark_pos_y = 0;
        switch($position) {
            case 'topleft':
            $watermark_pos_x = 0;
            $watermark_pos_y = 0;
            break;
            case 'topright':
            $watermark_pos_x = $this->width - $watermark->getWidth();
            $watermark_pos_y = 0;
            break;
            case 'bottomleft':
            $watermark_pos_x = 0;
            $watermark_pos_y = $this->height - $watermark->getHeight();
            break;
            case 'bottomright':
            $watermark_pos_x = $this->width - $watermark->getWidth();
            $watermark_pos_y = $this->height - $watermark->getHeight();
            break;
            case 'middle':
            $watermark_pos_x = ($this->width - $watermark->getWidth()) / 2;
            $watermark_pos_y = ($this->height - $watermark->getHeight()) / 2;
        }

        $this->image->compositeImage($watermark, imagick::COMPOSITE_OVER, $watermark_pos_x, $watermark_pos_y);
    }

    public function crop($top_x, $top_y, $bottom_x, $bottom_y) {
        $this->width = $bottom_x - $top_x;
        $this->height = $bottom_y - $top_y;
        $this->image->cropImage($top_x, $top_y, $bottom_x, $bottom_y);
    }

    public function rotate($degree, $color = '#FFFFFF') {
        $rgb = $this->html2rgb($color);
        $this->image->rotateImage(new ImagickPixel($rgb), $degree);
    }

    public function greyscale(){
        $this->image->setImageType(Imagick::IMGTYPE_GRAYSCALEMATTE);
    }

    private function filter($filter) {
        imagefilter($this->image, $filter);
    }

    private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000') {
        $draw = new ImagickDraw();
        $draw->setFontSize($size);
        $draw->setFillColor(new ImagickPixel($this->html2rgb($color)));
        $this->image->annotateImage($draw, $x, $y, 0, $text);
    }

    private function merge($merge, $x = 0, $y = 0, $opacity = 100) {
        $merge->getImage->setImageOpacity($opacity / 100);
        $this->image->compositeImage($merge, imagick::COMPOSITE_ADD, $x, $y);
    }

    private function html2rgb($color) {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        if (strlen($color) == 6) {
            list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array($r, $g, $b);
    }

    function __destruct() {
    }
}


	class ImageOld {
		private $file;
		private $image;
		private $width;
		private $height;
		private $bits;
		private $mime;
		
		public function __construct($file) {
			if (file_exists($file)) {
				$this->file = $file;
				
				$info = getimagesize($file);
				
				$this->width  = $info[0];
				$this->height = $info[1];
				$this->bits = isset($info['bits']) ? $info['bits'] : '';
				$this->mime = isset($info['mime']) ? $info['mime'] : '';
				
				if ($this->mime == 'image/gif') {
					$this->image = imagecreatefromgif($file);
					} elseif ($this->mime == 'image/png') {
					$this->image = imagecreatefrompng($file);
					} elseif ($this->mime == 'image/jpeg') {
					$this->image = imagecreatefromjpeg($file);
				}
				} else {
				exit('Error: Could not load image ' . $file . '!');
			}
		}
		
		public function getFile() {
			return $this->file;
		}
		
		public function getImage() {
			return $this->image;
		}
		
		public function getWidth() {
			return $this->width;
		}
		
		public function getHeight() {
			return $this->height;
		}
		
		public function getBits() {
			return $this->bits;
		}
		
		public function getMime() {
			return $this->mime;
		}
		
		public static function cachedname($filename, $extension, $data = array()){
			$md5 = md5($filename . implode('.', $data));
		 
			$directory 				= DIR_IMAGECACHE . substr($md5, 0, 3) . '/';
			$image_name 			= $md5 . 'x' . $data[0] . 'x' . $data[1] . 'x' . $data[2] .  '.' . $extension;
			$full_image_path 		= $directory . $image_name;
			$relative_image_path 	= DIR_IMAGECACHE_NAME . substr($md5, 0, 3) . '/' . $image_name;
			
			if (!is_dir($directory)){
				mkdir($directory, 0755, true);
			}
			
			return ['full_path' => $full_image_path, 'relative_path' => $relative_image_path];
		}
		
		public function save($file, $quality = IMAGE_QUALITY) {
			$info = pathinfo($file);
			
			$extension = strtolower($info['extension']);
			
			if (is_resource($this->image)) {
				if ($extension == 'jpeg' || $extension == 'jpg') {
					imagejpeg($this->image, $file, $quality);
					} elseif ($extension == 'png') {
					imagepng($this->image, $file);
					} elseif ($extension == 'gif') {
					imagegif($this->image, $file);
				}
				
				imagedestroy($this->image);
			}
		}
		
		public function save_webp($file, $quality = IMAGE_QUALITY) {
			if (is_resource($this->image)) {
				imagecolortransparent($this->image, imagecolorallocate($this->image, 255, 255, 255));
				imagewebp($this->image, $file, $quality);
				imagedestroy($this->image);
			}
		}
		
		public function resize($width = 0, $height = 0, $default = '') {
			if (!$this->width || !$this->height) {
				return;
			}
			
			$xpos = 0;
			$ypos = 0;
			$scale = 1;
			
			$scale_w = $width / $this->width;
			$scale_h = $height / $this->height;
			
			if ($default == 'w') {
				$scale = $scale_w;
				} elseif ($default == 'h') {
				$scale = $scale_h;
				} else {
				$scale = min($scale_w, $scale_h);
			}
			
			if ($scale == 1 && $scale_h == $scale_w && $this->mime != 'image/png') {
				return;
			}
			
			$new_width = (int)($this->width * $scale);
			$new_height = (int)($this->height * $scale);
			$xpos = (int)(($width - $new_width) / 2);
			$ypos = (int)(($height - $new_height) / 2);
			
			$image_old = $this->image;
			$this->image = imagecreatetruecolor($width, $height);
			
			if ($this->mime == 'image/png') {
				imagealphablending($this->image, false);
				imagesavealpha($this->image, true);
				$background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
				imagecolortransparent($this->image, $background);
				} else {
				$background = imagecolorallocate($this->image, 255, 255, 255);
			}
			
			imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
			
			imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->width, $this->height);
			imagedestroy($image_old);
			
			$this->width = $width;
			$this->height = $height;
		}
		
		public function watermark($watermark, $position = 'bottomright') {
			switch($position) {
				case 'topleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = 0;
				break;
				case 'topcenter':
				$watermark_pos_x = intval(($this->width - $watermark->getWidth()) / 2);
				$watermark_pos_y = 0;
				break;
				case 'topright':
				$watermark_pos_x = $this->width - $watermark->getWidth();
				$watermark_pos_y = 0;
				break;
				case 'middleleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = intval(($this->height - $watermark->getHeight()) / 2);
				break;
				case 'middlecenter':
				$watermark_pos_x = intval(($this->width - $watermark->getWidth()) / 2);
				$watermark_pos_y = intval(($this->height - $watermark->getHeight()) / 2);
				break;
				case 'middleright':
				$watermark_pos_x = $this->width - $watermark->getWidth();
				$watermark_pos_y = intval(($this->height - $watermark->getHeight()) / 2);
				break;
				case 'bottomleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = $this->height - $watermark->getHeight();
				break;
				case 'bottomcenter':
				$watermark_pos_x = intval(($this->width - $watermark->getWidth()) / 2);
				$watermark_pos_y = $this->height - $watermark->getHeight();
				break;
				case 'bottomright':
				$watermark_pos_x = $this->width - $watermark->getWidth();
				$watermark_pos_y = $this->height - $watermark->getHeight();
				break;
			}
			
			imagealphablending( $this->image, true );
			imagesavealpha( $this->image, true );
			imagecopy($this->image, $watermark->getImage(), $watermark_pos_x, $watermark_pos_y, 0, 0, $watermark->getWidth(), $watermark->getHeight());
			
			imagedestroy($watermark->getImage());
		}
		
		public function crop($top_x, $top_y, $bottom_x, $bottom_y) {
			$image_old = $this->image;
			$this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);
			
			imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->width, $this->height);
			imagedestroy($image_old);
			
			$this->width = $bottom_x - $top_x;
			$this->height = $bottom_y - $top_y;
		}
		
		public function rotate($degree, $color = 'FFFFFF') {
			$rgb = $this->html2rgb($color);
			
			$this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
			
			$this->width = imagesx($this->image);
			$this->height = imagesy($this->image);
		}
		
		private function filter() {
			$args = func_get_args();
			
			call_user_func_array('imagefilter', $args);
		}
		
		private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000') {
			$rgb = $this->html2rgb($color);
			
			imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
		}
		
		private function merge($merge, $x = 0, $y = 0, $opacity = 100) {
			imagecopymerge($this->image, $merge->getImage(), $x, $y, 0, 0, $merge->getWidth(), $merge->getHeight(), $opacity);
		}
		
		private function html2rgb($color) {
			if ($color[0] == '#') {
				$color = substr($color, 1);
			}
			
			if (strlen($color) == 6) {
				list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
				} elseif (strlen($color) == 3) {
				list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
				} else {
				return false;
			}
			
			$r = hexdec($r);
			$g = hexdec($g);
			$b = hexdec($b);
			
			return array($r, $g, $b);
		}
	}
