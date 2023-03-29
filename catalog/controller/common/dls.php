<?php

class ControllerCommonDls extends Controller {

	private function ecurl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$out = curl_exec($ch);
		curl_close($ch);

		return $out;
	}

	private function download_webpage($url) {
		$html = $this->ecurl($url);

		$doc = new DOMDocument();
		$doc->loadHTML($html);

		$html = str_replace('\images\\', '/images/', $html);

		$links = array();
		foreach ($doc->getElementsByTagName('link') as $link) {
			if ($link->getAttribute('rel') == 'stylesheet') {
				$links[] = $link->getAttribute('href');
			}
		}
		foreach ($doc->getElementsByTagName('script') as $script) {
			$links[] = $script->getAttribute('src');
		}

		foreach ($doc->getElementsByTagName('img') as $image) {
			$links[] = str_replace('\\', '/', $image->getAttribute('src'));
		}


		$base_url = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
		foreach ($links as $link) {
			$local_path = DIR_APPLICATION . '../dls/' . $link;
			$dir = DIR_APPLICATION . '../dls/' . pathinfo($link,  PATHINFO_DIRNAME);

			if (!is_dir($dir)){
				mkdir($dir, 0755, true);
			}

			file_put_contents($local_path, $this->ecurl($base_url . $link));

			$html = str_replace($link, 'https://e-apteka.com.ua/dls' . $link, $html);
		}

		return $html;

	}

	public function index(){
  		$this->response->setOutput($this->download_webpage('https://pharmacy.dls.gov.ua/check?EDRPOU=22974151'));
	}
}