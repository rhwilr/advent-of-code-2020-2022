<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\DataStructures\SevenSegment\SevenSegment;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day8 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        $input = $this->parseInput($input);

        $length = $input->map(fn ($line) => $line[1])
            ->flatten()
            ->map(fn ($n) => Str::of($n)->length());

        return $length->filter(function ($n) {
            return in_array($n, [2,3,4,7]);
        })
        ->count();
    }

    protected function partTwo(string $input)
    {
        $input = $this->parseInput($input);

        return $input->map(fn ($line) => $this->solveLine($line))
            ->sum();
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->explode(" | ")
                ->map(fn($part) => Str::of($part)->explode(' '))
            );
    }

    private function decodeSegments(Collection $patterns): SevenSegment
    {
        $segment = new SevenSegment();

        $trivialPatterns = $patterns->filter(fn ($n) => in_array(Str::of($n)->length(), [2,3,4,7]));
        foreach ($trivialPatterns as $pattern) {
            $pattern = Str::of($pattern)->split(1);

            $this->decodeTrivialNumber($segment, $pattern);
        }

        $multiPatterns = $patterns->filter(fn ($n) => !in_array(Str::of($n)->length(), [2,3,4,7]));
        while ($multiPatterns->isNotEmpty()) {
            $current = $multiPatterns->shift();
            $pattern = Str::of($current)->split(1);

            $decoded = $this->decodeMultiNumber($segment, $pattern);

            if (is_null($decoded)) {
                $multiPatterns->push($current);
            }
        }

        return $segment;
    }

    private function decodeTrivialNumber(SevenSegment $segment, Collection $pattern): ?int
    {
        // 1
        if ($pattern->count() == 2) {
            $segment->setCandidates(1, $pattern);

            return 1;
        }

        // 4
        if ($pattern->count() == 4) {
            $segment->setCandidates(4, $pattern);

            return 4;
        }

        // 7
        if ($pattern->count() == 3) {
            $segment->setCandidates(7, $pattern);

            return 7;
        }

        // 8
        if ($pattern->count() == 7) {
            $segment->setCandidates(8, $pattern);

            return 8;
        }

        return null;
    }

    private function decodeMultiNumber(SevenSegment $segment, Collection $pattern): ?int
    {
        // 2, 3, 5
        if ($pattern->count() == 5) {
            if ($segment->allSegmentsFrom(1, $pattern)) {
                $segment->setCandidates(3, $pattern);
                return 3;
            }

            if ($segment->allSegmentsIn(6, $pattern)) {
                $segment->setCandidates(5, $pattern);
                return 5;
            }

            if (($segment->hasSegmentsFor(3) &&!$segment->allSegmentsFrom(3, $pattern)) &&
                ($segment->hasSegmentsFor(5) && !$segment->allSegmentsFrom(5, $pattern))) {
                $segment->setCandidates(2, $pattern);
                return 2;
            }
        }

        // 0, 6, 9
        if ($pattern->count() == 6) {
            if ($segment->allSegmentsFrom(4, $pattern)) {
                $segment->setCandidates(9, $pattern);
                return 9;
            }

            if (($segment->allSegmentsFrom(7, $pattern) || $segment->allSegmentsFrom(1, $pattern)) && !$segment->allSegmentsFrom(4, $pattern)) {
                $segment->setCandidates(0, $pattern);
                return 0;
            }

            if (!$segment->allSegmentsFrom(7, $pattern) && !$segment->allSegmentsFrom(1, $pattern)) {
                $segment->setCandidates(6, $pattern);
                return 6;
            }

            return 1;
        }

        return null;
    }

    private function solveLine($line)
    {
        $segment = $this->decodeSegments($line[0]);

        return $this->decodeNumbers($line[1], $segment);
    }

    private function decodeNumbers(Collection $numbers, SevenSegment $segment): int
    {
        $number = $numbers->map(function ($n) use ($segment) {
            $pattern = Str::of($n)->split(1)->sort();

            return $segment->decode($pattern);
        })->join('');

        return intval($number);
    }
}
