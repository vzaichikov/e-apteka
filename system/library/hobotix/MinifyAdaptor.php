<?

namespace hobotix;


final class MinifyAdaptor
{

	const npmPackageLockFile = DIR_ENGINE . 'js/' . 'package-lock.json';


	public static function parseNPM(){
		$npmScripts 			= [];
		if (file_exists(self::npmPackageLockFile)){
			if ($npmDependencies = json_decode(file_get_contents(self::npmPackageLockFile), true)){
				foreach ($npmDependencies['dependencies'] as $npmDependency => $npmInfo){

					$npmPackageDirectory 	= DIR_ENGINE . 'js/node_modules/' . $npmDependency . '/';
					$npmPackageRelative		= '/js/node_modules/' . $npmDependency . '/';
					$npmPackageInfoFile 	= $npmPackageDirectory . 'package.json';

					if (file_exists($npmPackageInfoFile)){
						if ($npmPackageInfo = json_decode(file_get_contents($npmPackageInfoFile), true)){
							if (!empty($npmPackageInfo['main'])){
								if (file_exists($npmPackageDirectory . $npmPackageInfo['main']) && pathinfo($npmPackageInfo['main'],  PATHINFO_EXTENSION) == 'js'){											
									$npmScripts[] = ($npmPackageRelative . $npmPackageInfo['main']);
								}
							}
						}
					}
				}
			}
		}

		return $npmScripts;
	}

	private static function unlinkCacheDir($time) {
		if (is_dir(DIR_MINIFIED . $time)){

			foreach ($files = array_diff(scandir(DIR_MINIFIED . $time), ['.','..']) as $file){
				unlink(DIR_MINIFIED . $time . '/' . $file);
			}

			rmdir(DIR_MINIFIED . $time);
		}
	}

	public static function getCacheTime() {
		foreach (scandir(DIR_MINIFIED) as $subdir) {
			if (ctype_digit($subdir)) {
				return $subdir;
			}
		}

		$time = (string)time();
		mkdir(DIR_MINIFIED . '/' . $time, 0777);
		chmod(DIR_MINIFIED . '/' . $time, 0777);

		return $time;
	}


	public static function createFile($input, $type){
		if ($type == 'js'){
			$minifier = new \MatthiasMullie\Minify\JS;
		} elseif ($type == 'css'){
			$minifier = new \MatthiasMullie\Minify\CSS;
		}

		$files = [];
		$times = [];
		foreach ($input as $file){
			$file = DIR_ENGINE . ltrim($file, '/');
			if (file_exists($file) && $time = filemtime($file)){
				$files[] 		= $file;
				$times[$file] 	= $time;	
			}
		}

		if ($files){
			$cacheTime 	= self::getCacheTime(true);
			$maxTime	= max($times);

			if ($_SERVER['REMOTE_ADDR'] == ''){

			}

			if ($maxTime > $cacheTime){
				self::unlinkCacheDir($cacheTime);
				$cacheTime 	= self::getCacheTime(true);
			}

			$code 	  = md5(serialize($files));
			$absolute = DIR_MINIFIED . $cacheTime . '/' . $code . '.' . $type;
			$relative = DIR_MINIFIED_NAME . $cacheTime . '/' . $code . '.' . $type;

			if (!file_exists($absolute)){
				foreach($files as $file){
					$minifier->add($file);
				}

				$minifier->minify($absolute);
				chmod($absolute, 0777);
			}

			return $relative;
		}

		return false;
	}
}