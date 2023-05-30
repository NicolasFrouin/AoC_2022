<?php

$aoc_year = 2022;
$aoc_day = 9;

include_once "./aoc_input.php";

class Solve
{
	public $input = null;
	public $lines = [];

	public $head = [];
	public $tail = [];
	public $history = [];
	public $nbVisit = 0;

	const START_POS = ["x" => 0, "y" => 0];

	public function __construct($input)
	{
		$this->input = $input;
		$this->head = self::START_POS;
		$this->setTail();
		$this->solve();
	}

	public function solve()
	{
		$this->parseLines();
		foreach ($this->lines as $l) {
			$this->move(...explode(" ", $l));
		}
		print_r([
			"head" => $this->head,
			"tail" => $this->tail,
			"nbVisit" => $this->nbVisit,
			// "history" => $this->history,
		]);
	}

	public function follow()
	{
		$xDiff = $this->head["x"] - $this->tail["x"];
		$yDiff = $this->head["y"] - $this->tail["y"];
		$t = 0;
		if (abs($xDiff) < 2 && abs($yDiff) < 2)
			return;
		if (abs($xDiff) > 1) {
			$t++;
			$yMove = 0;
			if ($yDiff != 0) {
				$yMove = $yDiff > 0 ? 1 : -1;
			}
			$this->moveTail($xDiff > 0 ? 1 : -1, $yMove);
		}
		if (abs($yDiff) > 1) {
			$t += 2;
			$xMove = 0;
			if ($xDiff != 0) {
				$xMove = $xDiff > 0 ? 1 : -1;
			}
			$this->moveTail($xMove, $yDiff > 0 ? 1 : -1);
		}
	}

	public function setTail(int $x = 0, int $y = 0)
	{
		$this->tail["x"] = $x;
		$this->tail["y"] = $y;
		$this->addTailPosToHistory();
	}

	public function moveTail(int $x = 0, int $y = 0)
	{
		$this->tail["x"] += $x;
		$this->tail["y"] += $y;
		$this->addTailPosToHistory();
	}

	public function addTailPosToHistory()
	{
		$tailKeep = $this->tail["x"] . "," . $this->tail["y"];
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
		$this->lines = array_filter(explode("\n", $this->input), fn($l) => !empty($l));
	}
}

// $input = "R 4
// U 4
// L 3
// D 1
// R 4
// D 1
// L 5
// R 2";

// $input = "R 5";

$r = new Solve($input);

// < 6064
// > 5500
// = 5779