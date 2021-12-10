<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\DataStructures\SevenSegment\SevenSegment;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day9 extends AbstractSolver
{
    private int $lineLength = 0;
    private Collection $lowPointCoordinates;

    protected function partOne(string $input)
    {
        $input = $this->parseInput($input);

        return $this->findLowPoints($input)
            ->map(fn ($n) => 1 + $n)
            ->sum();
    }

    protected function partTwo(string $input)
    {
        $input = $this->parseInput($input);

        $this->findLowPoints($input)
            ->map(fn ($n) => 1 + $n)
            ->sum();

        return $this->findBasins($input)
            ->sortDesc()
            ->take(3)
            ->reduce(fn ($carry, $n) => $carry * $n, 1);
    }

    protected function parseInput(string $input): Collection
    {
        $lines = Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->split(1)
                ->map(fn($n) => intval($n))
            );

        $this->lineLength = $lines->firstOrFail()->count();

        return $lines;
    }

    private function findLowPoints(Collection $input)
    {
        $lowPoints = collect();
        $this->lowPointCoordinates = collect();

        foreach ($input as $y => $line) {
            foreach ($line as $x => $number) {
                if ($this->followLowPoints($input, $number, $x, $y)) {
                    $lowPoints->push($number);
                }
            }
        }

        return $lowPoints;
    }

    private function followLowPoints(Collection $input, int $number, int $x, int $y)
    {
        $lowerPoint = collect([
            $input->get($y)?->get($x-1),
            $input->get($y)?->get($x+1),
            $input->get($y - 1)?->get($x),
            $input->get($y + 1)?->get($x),
        ])
            ->filter(fn ($n) => !is_null($n))
            ->every(fn ($n) => $number < $n);

        // lowest point
        if ($lowerPoint) {
            $this->lowPointCoordinates->push([$x, $y]);
            return true;
        }

        return false;
    }

    private function findBasins(Collection $input): Collection
    {
        $sizes = collect();

        foreach ($this->lowPointCoordinates as $lowPoint) {
            [$x, $y] = $lowPoint;
            $size = $this->getBasinSize($input, $x, $y);

            $sizes->push($size);
        }

        return $sizes;
    }

    private function getBasinSize(Collection $input, int $x, int $y): int
    {
        $size = 0;
        $neighbors = collect([[$x, $y]]);
        $seen = collect();

        while ($neighbors->isNotEmpty()) {
            $neighbor = $neighbors->pop();
            $px = $neighbor[0];
            $py = $neighbor[1];

            if (!$seen->has("$px:$py") && $this->isPartOfBasin($input, $neighbor)) {
                $size += 1;
                $seen->put("$px:$py", true);

                $neighbors->push([$px + 1, $py]);
                $neighbors->push([$px - 1, $py]);
                $neighbors->push([$px, $py + 1]);
                $neighbors->push([$px, $py - 1]);
            }
        }

        return $size;
    }

    private function isPartOfBasin(Collection $input, array $point): bool
    {
        $x = $point[0];
        $y = $point[1];

        $value = $input->get($y)?->get($x-1);

        return !is_null($value) && $value !== 9;
    }
}
