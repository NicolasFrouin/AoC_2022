<?php

$aoc_year = 2022;
$aoc_day = 11;
$test_input = false;

include_once "./aoc_input.php";

class Solve extends SolveBase
{
	public function __construct($input)
	{
		parent::__construct($input);
	}
	const DEBUG = 1;
	protected function parseLines()
	{
		$this->lines = array_filter(explode("\r\n\r\n", $this->input), fn ($l) => !empty($l));
	}
	public function showResults()
	{
		parent::showResults();
		print $this->results;
		// print_r([
		// 	"monkeys" => $this->monkeys,
		// ]);
	}

	public $monkeys = [];
	public $tmp;
	public $results;

	const BORED_DIVIDE_VALUE = 3;
	const NB_OF_ROUNDS = 20;
	const NB_OF_MOST_ACTIVE = 2;

	public function solve()
	{
		$this->parseMonkeys();
		for ($i = 0; $i < self::NB_OF_ROUNDS; $i++) {
			$this->iterate();
		}
		$this->sort();
		$mostActiveMonkeys = array_slice($this->monkeys, 0, self::NB_OF_MOST_ACTIVE);
		$this->results = array_reduce($mostActiveMonkeys, fn($c, $v) => $c *= $v["nbInspect"], 1);
	}

	public function iterate()
	{
		foreach ($this->monkeys as $m) {
			// print $m["id"] . " : " . PHP_EOL;
			$allItems = $this->monkeys[$m["id"]]["items"];
			foreach ($allItems as $index => $item) {
				$this->monkeys[$m["id"]]["nbInspect"]++;
				$opRes = $this->monkeyOperation($m["op"], $item, $m["value"]);
				$testRes = $this->monkeyTest($opRes, $m["div"]);
				$nextMonkey = trim($m[$testRes ? "true" : "false"]);
				// print "\t$item => $opRes -> " . $nextMonkey . PHP_EOL;
				// $this->tmp[$nextMonkey][] = $opRes;
				$delItem = array_splice($this->monkeys[$m["id"]]["items"], $index, 1, "");
				array_push($this->monkeys[$nextMonkey]["items"], $opRes);
			}
			echo "";
			try {
				$newItemArray = array_filter($this->monkeys[$m["id"]]["items"], fn ($v) => !empty($v));
				$this->monkeys[$m["id"]]["items"] = $newItemArray;
			} catch (\Throwable $th) {
				echo "";
			}
		}
	}

	public function sort()
	{
		usort($this->monkeys, fn($a, $b) => $b["nbInspect"] - $a["nbInspect"]);
	}

	public function parseMonkeys()
	{
		$regex = "/^Monkey (?'id'\d+)\D+(?'items',? \d+\g'items'*).+?(?=old )old (?'op'\*|\+) (?'value'(?:\d+|\w+)).*? by (?'div'\d+).*?monkey (?'true'\d+).*?monkey (?'false'\d+)/ims";
		preg_match_all($regex, $this->input, $matches, PREG_SET_ORDER, 0);
		foreach ($matches as $match) {
			$this->monkeys[$match["id"]] = $match;
		}
		foreach ($this->monkeys as $i => $m) {
			$this->monkeys[$m["id"]]["items"] = array_map(fn ($i) => intval($i), explode(",", $m["items"]));
			$this->monkeys[$m["id"]]["nbInspect"] = 0;
		}
	}

	public function monkeyOperation($op, $a, $b)
	{
		return intval([
			"+" => fn ($a, $b) => $a + $b,
			"*" => fn ($a, $b) => $a * $b,
		][$op]($a, $b == "old" ? $a : $b) / self::BORED_DIVIDE_VALUE);
	}

	public function monkeyTest($value, $test)
	{
		return $value % $test == 0;
	}
}

if ($test_input) {
	$input = "Monkey 0:
  Starting items: 79, 98
  Operation: new = old * 19
  Test: divisible by 23
    If true: throw to monkey 2
    If false: throw to monkey 3

Monkey 1:
  Starting items: 54, 65, 75, 74
  Operation: new = old + 6
  Test: divisible by 19
    If true: throw to monkey 2
    If false: throw to monkey 0

Monkey 2:
  Starting items: 79, 60, 97
  Operation: new = old * old
  Test: divisible by 13
    If true: throw to monkey 1
    If false: throw to monkey 3

Monkey 3:
  Starting items: 74
  Operation: new = old + 3
  Test: divisible by 17
    If true: throw to monkey 0
    If false: throw to monkey 1";
}

$r = new Solve($input);
