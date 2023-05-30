<?php

$aoc_year = 2022;
$aoc_day = 10;
$test_input = false;

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
			print array_reduce(str_split($this->results, self::BASE_CHECK), fn ($c, $l) => $c . $l . PHP_EOL);
		}
	}

	public $cycleCount = 0;
	public $cycles = [];
	public $registerX = 1;
	public $results = "";

	const SPRITE_SIZE = 3;
	const BASE_CHECK = 40;
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
				$this->draw();
			}
			if (!empty($action)) {
				$this->$action($value);
			}
			continue;
		}
	}

	public function draw()
	{
		if ($this->registerX <= ($this->cycleCount % self::BASE_CHECK) && ($this->cycleCount % self::BASE_CHECK) <= $this->registerX + self::SPRITE_SIZE - 1) {
			$this->results .= "#";
		} else {
			$this->results .= ".";
		}
		return;
	}

	public function addxAction($v)
	{
		$this->registerX += intval($v);
	}
}
if ($test_input) {
	$input = "addx 15
addx -11
addx 6
addx -3
addx 5
addx -1
addx -8
addx 13
addx 4
noop
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx -35
addx 1
addx 24
addx -19
addx 1
addx 16
addx -11
noop
noop
addx 21
addx -15
noop
noop
addx -3
addx 9
addx 1
addx -3
addx 8
addx 1
addx 5
noop
noop
noop
noop
noop
addx -36
noop
addx 1
addx 7
noop
noop
noop
addx 2
addx 6
noop
noop
noop
noop
noop
addx 1
noop
noop
addx 7
addx 1
noop
addx -13
addx 13
addx 7
noop
addx 1
addx -33
noop
noop
noop
addx 2
noop
noop
noop
addx 8
noop
addx -1
addx 2
addx 1
noop
addx 17
addx -9
addx 1
addx 1
addx -3
addx 11
noop
noop
addx 1
noop
addx 1
noop
noop
addx -13
addx -19
addx 1
addx 3
addx 26
addx -30
addx 12
addx -1
addx 3
addx 1
noop
noop
noop
addx -9
addx 18
addx 1
addx 2
noop
noop
addx 9
noop
noop
noop
addx -1
addx 2
addx -37
addx 1
addx 3
noop
addx 15
addx -21
addx 22
addx -6
addx 1
noop
addx 2
addx 1
noop
addx -10
noop
noop
addx 20
addx 1
addx 2
addx 2
addx -6
addx -11
noop
noop
noop";
}

$r = new Solve($input);

// EFUGLPAP
