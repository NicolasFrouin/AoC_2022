<?php

if (empty($aoc_year))
	throw new Error('$aoc_year not set');
if (empty($aoc_day))
	throw new Error('$aoc_day not set');

if (file_exists("./aoc-input-$aoc_year-$aoc_day.txt")) {
	$input = file_get_contents("./aoc-input-$aoc_year-$aoc_day.txt");
} else {
	$aoc_session = "";

	$context = stream_context_create([
		"http" => [
			"method" => "GET",
			"header" => "Cookie: session=" . $aoc_session,
		]
	]);

	$input = file_get_contents("https://adventofcode.com/$aoc_year/day/$aoc_day/input", false, $context);

	file_put_contents("./aoc-input-$aoc_year-$aoc_day.txt", $input);
}

if (empty($input))
	throw new Error('$input empty');