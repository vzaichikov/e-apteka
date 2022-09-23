<?

	class FPCTimer {
		
		private $timeStart;
		private $microsecondsStart;
		private $timeStop;
		private $microsecondsStop;
		
		public function __construct() {
			$this->start();
		}
		
		public function start(): void {
			[$this->microsecondsStart, $this->timeStart] = explode(' ', microtime());
			$timeStop         = null;
			$microsecondsStop = null;
		}
		
		public function stop(): void {
			[$this->microsecondsStop, $this->timeStop] = explode(' ', microtime());
		}
		
		public function getTime(): float {
			$timeEnd         = $this->timeStop;
			$microsecondsEnd = $this->microsecondsStop;
			if (!$timeEnd) {
				[$microsecondsEnd, $timeEnd] = explode(' ', microtime());
			}
			
			$seconds      = $timeEnd - $this->timeStart;
			$microseconds = $microsecondsEnd - $this->microsecondsStart;
			
			// now the integer section ($seconds) should be small enough
			// to allow a float with 6 decimal digits
			return round(($seconds + $microseconds), 6);
		}
	}