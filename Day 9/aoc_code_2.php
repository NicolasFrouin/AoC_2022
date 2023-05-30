<?php

$aoc_year = 2022;
$aoc_day = 9;

include_once "./aoc_input.php";

class Solve
{
	public $input = null;
	public $lines = [];

	public $head = [];
	public $tails = [];
	public $history = [];
	public $nbVisit = 0;

	const DEBUG = false;

	const START_POS = ["x" => 0, "y" => 0];
	const TAILS_NUMBER = 9;

	public function __construct($input)
	{
		$this->input = $input;
		$this->head = self::START_POS;
		$this->initTails();
		$this->solve();
	}

	public function solve()
	{
		$this->parseLines();
		foreach ($this->lines as $l) {
			if (self::DEBUG) echo ("========== $l ==========" . PHP_EOL);
			$this->move(...explode(" ", $l));
			$this->state();
			if (self::DEBUG) echo (PHP_EOL);
		}
		$this->draw();
		print_r([
			"head" => $this->head,
			"tails" => $this->tails,
			"nbVisit" => $this->nbVisit,
			"history" => $this->history,
		]);
	}

	public function follow()
	{
		for ($i = 1; $i <= self::TAILS_NUMBER; $i++) {
			if (isset($this->tails[$i - 1])) {
				$xDiff = $this->tails[$i - 1]["x"] - $this->tails[$i]["x"];
				$yDiff = $this->tails[$i - 1]["y"] - $this->tails[$i]["y"];
			} else {
				$xDiff = $this->head["x"] - $this->tails[$i]["x"];
				$yDiff = $this->head["y"] - $this->tails[$i]["y"];
			}
			if (abs($xDiff) < 2 && abs($yDiff) < 2)
				continue;
			if (abs($xDiff) > 1) {
				$yMove = 0;
				if ($yDiff != 0) {
					$yMove = $yDiff > 0 ? 1 : -1;
				}
				$this->moveTail($i, $xDiff > 0 ? 1 : -1, $yMove);
				continue;
			}
			if (abs($yDiff) > 1) {
				$xMove = 0;
				if ($xDiff != 0) {
					$xMove = $xDiff > 0 ? 1 : -1;
				}
				$this->moveTail($i, $xMove, $yDiff > 0 ? 1 : -1);
				continue;
			}
		}
	}

	public function state()
	{
		if (!self::DEBUG) return;
		print_r([count($this->tails), $this->tails]);
		$w = 26;
		$h = 21;
		$o = ["x" => -11, "y" => -5];
		$map = array_fill($o["y"], $h, array_fill($o["x"], $w, "·"));
		$map[0][0] = "S";
		foreach (array_reverse($this->tails, true) as $i => $pos) {
			$map[$pos["y"]][$pos["x"]] = $i;
		}
		$map[$this->head["y"]][$this->head["x"]] = "H";
		// print_r($map);
		foreach (array_reverse($map) as $line) {
			$pl = array_reduce($line, fn ($c, $v) => trim($c) . " " . $v, "");
			print $pl . "\n";
		}
	}

	public function draw()
	{
		if (!self::DEBUG) return;
		$w = 26;
		$h = 21;
		$o = ["x" => -11, "y" => -5];
		$map = array_fill($o["y"], $h, array_fill($o["x"], $w, "·"));
		foreach ($this->history as $pos => $_) {
			[$x, $y] = explode(",", $pos);
			$map[$y][$x] = "#";
		}
		$map[0][0] = "S";
		// print_r($map);
		foreach (array_reverse($map) as $line) {
			$pl = array_reduce($line, fn ($c, $v) => trim($c) . " " . $v, "");
			print $pl . "\n";
		}
	}

	public function initTails()
	{
		for ($i = 1; $i <= self::TAILS_NUMBER; $i++) {
			$this->tails[$i] = self::START_POS;
		}
		$this->addTailPosToHistory();
	}

	public function moveTail(int $n, int $x = 0, int $y = 0)
	{
		$this->tails[$n]["x"] += $x;
		$this->tails[$n]["y"] += $y;
		$this->addTailPosToHistory();
	}

	public function addTailPosToHistory()
	{
		$tailKeep = $this->tails[self::TAILS_NUMBER]["x"] . "," . $this->tails[self::TAILS_NUMBER]["y"];
		if (empty($this->history[$tailKeep])) {
			$this->history[$tailKeep] = ++$this->nbVisit;
		}
	}

	public function move(string $dir, int $nb)
	{
		switch ($dir) {
			case "U":
				for ($i = 0; $i < $nb; $i++) {
					$this->head["y"]++;
					$this->follow();
				}
				break;
			case "D":
				for ($i = 0; $i < $nb; $i++) {
					$this->head["y"]--;
					$this->follow();
				}
				break;
			case "L":
				for ($i = 0; $i < $nb; $i++) {
					$this->head["x"]--;
					$this->follow();
				}
				break;
			case "R":
				for ($i = 0; $i < $nb; $i++) {
					$this->head["x"]++;
					$this->follow();
				}
				break;
		}
	}

	private function parseLines()
	{
		$this->lines = array_filter(explode("\n", $this->input), fn ($l) => !empty($l));
	}
}

// $input = "R 5
// U 8
// L 8
// D 3
// R 17
// D 10
// L 25
// U 20";

new Solve($input);

// < 2337
// > 2000
// < 2336
