<?php
class Response {
	private $headers = array();
	private $level = 0;
	private $output;

	public function addHeader($header) {
		$this->headers[] = $header;
	}

	public function redirect($url, $status = 301) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}

	public function setCompression($level) {
		$this->level = $level;
	}

	public function getOutput() {
		return $this->output;
	}
	
	public function setOutput($output) {
		if (!defined('IS_ADMIN')){
            $output = str_ireplace('https://', 'https://', $output);
        }
		
		$this->output = $output;
	}

	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

	public function minify(){
		$minifier = new \voku\helper\HtmlMin();
		$this->output = $minifier->minify($this->output);
	}

	public function returnOutput() {
		return $this->output;
	}

	public function output() {
		global $timer;

		if ($this->output) {
			$output = $this->level ? $this->compress($this->output, $this->level) : $this->output;
			if (!headers_sent()) {
				foreach ($this->headers as $header) {
					header($header, true);
				}
			}

			echo $output;
			$this->sqlDebug();
		}
	}

	public function sqlDebug(){
		if (defined('DEBUGSQL') && DEBUGSQL) {
			$queries = $GLOBALS['sql'];

			$totalSQLTime = 0;
			foreach ($GLOBALS['sql'] as $query) {
				$totalSQLTime += $query['time'];
			}

			$line = '<style>pre{border:none!important;}</style><div id="debug" style="position:relative; bottom:0; z-index:1000; width:100%;min-height:100px; padding:20px; background: #ff3333; ">';
			$line .= '<div style="width:90%;margin:0 auto;">';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Page gen time ' . ($GLOBALS['timer'])->getTime() . ' sec</div>';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Total SQL time ' . $totalSQLTime . ' sec</div>';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Total SQL queries ' . count($GLOBALS['sql']) . '</div>';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Mem PHP ' . size_convert(memory_get_usage(false)) . '</div>';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Mem SYS ' . size_convert(memory_get_usage(true)) . '</div>';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Peak Mem PHP ' . size_convert(memory_get_peak_usage(false)) . '</div>';
			$line .= '	<div style="color:white; font-size:14px; line-height:20px">Peak Mem SYS ' . size_convert(memory_get_peak_usage(true)) . '</div>';			
			foreach ($queries as $query) {					
				$line .= '<div style=" width:100%; color:';
				if ($querytime > 0.004) {
					$line .= '#ff3333;';
				} else {
					$line .= '#009900; ';
				}
				$line .= 'font-size:12px;background:white;margin-bottom:0px;padding:2px;"> time:' . round($query['time'],4)  . ' sec, <span style="color:black;">'. $query['fromCache']. '</span></div>';					
				$line .= '<div style="width:100%; color:#000; font-size:10px; background:white; padding:1px 2px; border-top:1px solid #ddd">' . $query['query2'] . '</div>';

				$line .= '<div style="width:100%; border-top:1px solid #ddd;  font-family:Courier; font-size:10px; background:white;  margin-bottom:2px; padding:1px 2px;">';
				foreach ($query['debug'] as $debug){					
					$line .= "# " . $debug['function'] . ', line ' . $debug['line'] . ' at ' . $debug['class'] . ' in ' . $debug['file'] . '<br />';
				}
				$line .= "</div>";

			};

			$line .= '</div></div>';
			echo $line;				
		}
	}
}
