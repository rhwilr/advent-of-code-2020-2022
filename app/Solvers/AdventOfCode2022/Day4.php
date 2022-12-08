<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day3 extends AbstractSolver
{
    protected function parse(string $input): Collection
    {
        return Str::of(trim($input))
            ->explode("\n");
    }

    protected function partOne(string $input)
    {
        return $this->parse($input)
            ->map(function ($rucksack) {
                $length = mb_strlen($rucksack) / 2;

                $first = str_split(substr($rucksack, 0, $length));
                $second = str_split(substr($rucksack, $length, $length));

                return [
                    $first,
                    $second
                ];
            })
            ->map(function ($param) {
                [$first, $second] = $param;

                $char =  collect($first)
                    ->intersect(collect($second))
                    ->unique()
                    ->first();

                $ascii = ord($char);

                // Uppercase from 65-90 to 27-52
                if ($ascii < 91) {
                    return $ascii - 38;
                }

                // Lowercase from 97-122 to 1-26
                return $ascii - 96;
            })
            ->sum();
    }

    protected function partTwo(string $input)
    {
        return $this->parse($input)
            ->map(function ($rucksack) {
                return collect(str_split($rucksack))
                    ->map(function ($char) {
                        $ascii = ord($char);

                        // Uppercase from 65-90 to 27-52
                        if ($ascii < 91) {
                            return $ascii - 38;
                        }

                        // Lowercase from 97-122 to 1-26
                        return $ascii - 96;
                    });
            })
            ->chunk(3)
            ->map(function (Collection $group) {
                [$e1, $e2, $e3] = $group->values();

                return collect($e1)
                    ->intersect($e2)
                    ->intersect($e3)
                    ->unique()
                    ->first();
            })
            ->sum();
    }
}
