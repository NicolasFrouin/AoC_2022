<?php

$aoc_year = 2022;
$aoc_day = 10;

include_once "./aoc_input.php";

class Solve extends SolveBase
{
	public function __construct($input)
	{
		parent::__construct($input);
	}
	const DEBUG = 3;
	public function showResults()
	{
		parent::showResults();
		if (self::DEBUG == 2) {
			print_r([
				$this->cycleCount,
				$this->cycles,
				$this->registerX,
			]);
		} else if (self::DEBUG == 3) {
			print_r($this->results);
			print_r($this->deb);
		}
	}

	public $cycleCount = 0;
	public $cycles = [];
	public $registerX = 1;
	public $results;

	const TO_CKECK = [20, 60, 100, 140, 180, 220];
	const BASE_CHECK = 20;
	const PAD_CKECK = 40;
	const DICT = [
		"addx" => ["cost" => 2, "action" => "addxAction"],
		"noop" => ["cost" => 1, "action" => null],
	];


	public function solve()
	{
		foreach ($this->lines as $line) {
			$exLine = explode(" ", $line);
			$ins = trim($exLine[0]);
			$value = isset($exLine[1]) ? trim($exLine[1]) : null;
			$cost = self::DICT[$ins]["cost"];
			$action = self::DICT[$ins]["action"];
			for ($i = 0; $i < intval($cost); $i++) {
				$this->cycleCount++;
				$this->cycles[$this->cycleCount] = $this->registerX;
			}
			if (!empty($action)) {
				$this->$action($value);
			}
			continue;
		}
		if ($this->cycleCount < self::BASE_CHECK) throw new ErrorException('$this->cycleCount < self::BASE_CHECK');
		$this->results["count"] = 0;
		$n = 0;
		while ($this->cycleCount >= ($cycleCheck = self::BASE_CHECK + self::PAD_CKECK * $n)) {
			$this->results["count"] += $cycleCheck * $this->cycles[$cycleCheck];
			$this->deb[] = $cycleCheck . " * " . $this->cycles[$cycleCheck] . " = " . $cycleCheck * $this->cycles[$cycleCheck];
			$n++;
		}
	}

	public function addxAction($v)
	{
		$this->registerX += intval($v);
		return $this->registerX;
	}
}

$r = new Solve($input);
