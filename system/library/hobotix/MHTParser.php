<?php


namespace hobotix;


class MHTParser {
	private $mht_content;
	private $parts;

	public function __construct($mht_file_path) {
		$this->mht_content = file_get_contents($mht_file_path);
		$this->parts = [];
	}

	public function parse() {
		$parts = preg_split("/------=_NextPart_/", $this->mht_content);

      // Loop through each part and extract its content and headers
		foreach ($parts as $part) {
        // Match the headers and content for the part
			if (preg_match('/Content-Type: (.+?)\r\n(.+?)\r\n\r\n(.+)/s', $part, $matches)) {
				$content_type 	= $matches[1];
				$charset 		= preg_match('/charset=(.+?)(\s|$)/i', $content_type, $charset_matches) ? $charset_matches[1] : null;
				$headers 		= $matches[2];
				$content 		= $matches[3];		

				$charset = trim($charset, '"');
				$content = $this->convert_to_utf8($content, $charset);
          
				$this->parts[] = array(
					'content_type' 	=> $content_type,
					'charset'		=> $charset,
					'headers' 		=> $headers,
					'content' 		=> $content
				);
			}
		}
	}

	public function get_parts() {
		return $this->parts;
	}

	public function get_content_type($index) {
		return isset($this->parts[$index]['content_type']) ? $this->parts[$index]['content_type'] : null;
	}

	public function get_headers($index) {
		return isset($this->parts[$index]['headers']) ? $this->parts[$index]['headers'] : null;
	}

	public function get_content($index) {
		return isset($this->parts[$index]['content']) ? $this->parts[$index]['content'] : null;
	}

	private function convert_to_utf8($content, $charset) {    
		$content = urldecode($content);
		$content = str_ireplace('=3D', '=', $content);
		$content = str_ireplace('3D"', '"', $content);
		$content = str_ireplace("\r\n", "\n", $content);
		$content = str_ireplace('=' . PHP_EOL, '', $content);
		$content = str_ireplace('<=', '<', $content);

		// Remove Word styles and formatting from the HTML
        $content = preg_replace('/(<\/?)o:[^>]*>/', '$1>', $content);
        $content = preg_replace('/ style=[^>]*>/', '>', $content);         
    	$content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/s', '', $content);		
        $content = str_ireplace(['<>','</>'], '', $content);
    
		if ($charset && !mb_check_encoding($content, 'UTF-8')) {
			$content = mb_convert_encoding($content, 'UTF-8', $charset);
			$content = str_replace('charset=' . $charset, 'charset=utf-8', $content);
		}

		return $content;
	}

	public function get_html() {    
		foreach ($this->parts as $part) {
			if (strpos($part['content_type'], 'text/html') !== false) {
				return $part['content'];
			}
		}

		return null;
	}
}