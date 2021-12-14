<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day3 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        $lines = $this->parseInput($input);
        $gamma = $this->getMostCommonBitMap($lines)->join('');
        $epsilon = $this->getLeastCommonBitMap($lines)->join('');

        return bindec($gamma) * bindec($epsilon);
    }

    protected function partTwo(string $input)
    {
        $lines = $this->parseInput($input);

        $oxygen = $this->findOxygenRating($lines);
        $co2 = $this->findCO2Rating($lines);

        return $oxygen * $co2;
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => Str::of($line)
                ->split('//')
                ->filter(fn ($n) => $n !== '')
                ->map(fn ($n) => intval($n)));
    }

    protected function getMostCommonBitMap(Collection $input): Collection
    {
        $minCount = $input->count() / 2;

        // Count up all the 1s per position
        $ones = $input->reduce(function ($carry, $bits) {
            return $bits->map(fn ($bit, $key) =>
                $bit + $carry[$key]
            );
        }, array_fill(1, $input[0]->count(), 0));

        return $ones->map(fn ($bit) => $bit >= $minCount ? 1 : 0);
    }

    protected function getLeastCommonBitMap(Collection $input): Collection
    {
        return $this->getMostCommonBitMap($input)
            ->map(fn ($bit) => $bit == 1 ? 0 : 1);
    }

    /**
     * @param Collection $lines
     * @return int
     */
    protected function findOxygenRating(Collection $lines): int
    {
        $ones = $this->getMostCommonBitMap($lines);

        foreach (range(1, $ones->count()) as $key) {
            $lines = $lines->filter(fn($line) => $line[$key] == $ones[$key])->values();

            if ($lines->count() === 1) {
                return bindec($lines->first()->join(''));
            }
            $ones = $this->getMostCommonBitMap($lines);
        }

        return bindec($lines->first()->join(''));
    }

    /**
     * @param Collection $lines
     * @return int
     */
    protected function findCO2Rating(Collection $lines): int
    {
        $ones = $this->getLeastCommonBitMap($lines);

        foreach (range(1, $ones->count()) as $key) {
            $lines = $lines->filter(fn($line) => $line[$key] == $ones[$key])->values();

            if ($lines->count() === 1) {
                return bindec($lines->first()->join(''));
            }
            $ones = $this->getLeastCommonBitMap($lines);
        }

        return bindec($lines->first()->join(''));
    }

}
