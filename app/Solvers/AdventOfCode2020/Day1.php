<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use Illuminate\Support\Str;
use RuntimeException;

class Day1 extends AbstractSolver
{
    protected function partOne(string $input): string
    {
        $parts = Str::of($input)
            ->explode("\n")
            ->map(function ($item) {
                return (int)trim($item);
            });

        foreach ($parts as $part1) {
            foreach ($parts as $part2) {
                if ($part1 + $part2 === 2020) {
                    return (string)($part1 * $part2);
                }
            }
        }

        throw new RuntimeException('Not working');
    }

    protected function partTwo(string $input): string
    {
        $parts = Str::of($input)
            ->explode("\n")
            ->map(function ($item) {
                return (int)trim($item);
            });

        foreach ($parts as $part1) {
            foreach ($parts as $part2) {
                foreach ($parts as $part3) {
                    if ($part1 + $part2 + $part3 === 2020) {
                        return (string)($part1 * $part2 * $part3);
                    }
                }
            }
        }

        throw new RuntimeException('Not working');
    }
}
