<?

namespace hobotix;

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

		return round(($seconds + $microseconds), 6);
	}
}

class Interval
{
	private $data;
	private $timezone;
	private $start;
	private $end;

	public function __construct($serialized, $timezoneName = false)
	{

		if (!$timezoneName){
			$timezoneName = date_default_timezone_get();
		}

		$this->parse($serialized);
		$this->timezone = new \DateTimeZone($timezoneName);
		$this->makeStart();
		$this->makeEnd();
	}

	public function contains(\DateTimeInterface $date)
	{
		return $date >= $this->start && $date <= $this->end;
	}

	public function isNow()
	{
		$now = new \DateTimeImmutable('now', $this->timezone);
		return $this->contains($now);
	}

	private function parse($serialized)
	{
		$parts = explode('-', $serialized);

		$this->data = [
			'start' => $this->parsePart($parts[0]),
			'end' => $this->parsePart($parts[1]),
		];
	}

	private function makeStart()
	{
		$this->start = $this->makeDate($this->data['start']['hour'], $this->data['start']['minute']);
	}

	private function makeEnd()
	{
		$this->end = $this->makeDate($this->data['end']['hour'], $this->data['end']['minute']);
		$this->ensureEndIsAfterStart();
	}

	private function parsePart($part)
	{
		list($hour, $minute) = explode(':', $part);

		return [
			'hour' => $hour,
			'minute' => $minute,
		];
	}

	private function makeDate($hour, $minute)
	{
		list($day, $month, $year) = explode('.', date('d.m.Y'));

		$date = new \DateTime('now', $this->timezone);

		$date->setDate($year, $month, $day);
		$date->setTime($hour, $minute);

		return $date;
	}

	private function ensureEndIsAfterStart()
	{
		if ($this->start > $this->end)
		{
			$this->end->add(new \DateInterval('P1D'));
		}
	}
}
