<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Str;
use Spatie\Regex\MatchResult;
use Spatie\Regex\Regex;

class Day2 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->map(function ($item) {
                return trim($item);
            })
            ->map(function ($item) {
                return Regex::match('/(\d+)-(\d+)\s([a-z]):\s(.*)/', $item);
            })
            ->filter(function (MatchResult $matches) {
                $min = $matches->group(1);
                $max = $matches->group(2);
                $letter = $matches->group(3);
                $input = $matches->group(4);

                $regex = sprintf('/[^%s]*(%s[^%s]*){%s,%s}/', $letter, $letter, $letter, $min, $max);
                $matching = Regex::match($regex, $input)->result();

                return $matching == $input;
            })
            ->count();
    }

    protected function partTwo(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->map(function ($item) {
                return trim($item);
            })
            ->map(function ($item) {
                return Regex::match('/(\d+)-(\d+)\s([a-z]):\s(.*)/', $item);
            })
            ->filter(function (MatchResult $matches) {
                $first = $matches->group(1);
                $second = $matches->group(2);
                $letter = $matches->group(3);
                $input = Str::of($matches->group(4))->split('//')->filter();

                $firstLetter = $input->get($first);
                $secondLetter = $input->get($second);

                return ($firstLetter == $letter) xor ($secondLetter == $letter);
            })
            ->count();
    }
}
