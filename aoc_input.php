<?php

if (empty($aoc_year))
	throw new Error('$aoc_year not set');
if (empty($aoc_day))
	throw new Error('$aoc_day not set');

$inputFile = "./aoc-input-$aoc_year-$aoc_day.txt";

if (file_exists($inputFile) && filesize($inputFile)) {
	$input = file_get_contents($inputFile);
} else {
	$aoc_session = "53616c7465645f5f3040b1362896953aeb120c773111897c6f8908e4f6787acbc6a9c023b5ece65196515ae952d52e4882128b989606adbae49a5e7b09e20956";

	$context = stream_context_create([
		"http" => [
			"method" => "GET",
			"header" => "Cookie: session=" . $aoc_session,
		]
	]);

	$input = file_get_contents("https://adventofcode.com/$aoc_year/day/$aoc_day/input", false, $context);

	file_put_contents($inputFile, $input);
}

class SolveBase
{
	protected $input;
	protected $lines;
	protected $deb;

	const DEBUG = 0;

	public function __construct($input)
	{
		$this->input = $input;
		$this->parseLines();
		$this->solve();
		$this->showResults();
	}

	public function solve()
	{
	}

	public function showResults()
	{
		if (!self::DEBUG) return;
		else if (self::DEBUG == -1) {
			print_r((new ReflectionClass(self::class))->getAttributes());
		} else if (self::DEBUG == 1) {
			print_r($this->deb);
		}
	}

	protected function parseLines()
	{
		$this->lines = array_filter(explode("\n", $this->input), fn ($l) => !empty($l));
	}
}

if (empty($input))
	throw new Error('$input empty');
