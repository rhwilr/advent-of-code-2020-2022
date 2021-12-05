<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

class Day5 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        $parsed = $this->parseInput($input);

        [$sizeX, $sizeY] = $this->findSize($parsed);

        $map = $this->buildMap($sizeX, $sizeY);

        $points = $this->expandLines($parsed);

        $map = $this->fillMap($map, $points);

        // the number of points where at least two lines overlap
        return $map->flatten()
            ->filter(fn ($n) => $n >= 2)
            ->count();
    }

    protected function partTwo(string $input)
    {
        $parsed = $this->parseInput($input);

        [$sizeX, $sizeY] = $this->findSize($parsed);

        $map = $this->buildMap($sizeX, $sizeY);

        $points = $this->expandLines($parsed, true);

        $map = $this->fillMap($map, $points);

        // the number of points where at least two lines overlap
        return $map->flatten()
            ->filter(fn ($n) => $n >= 2)
            ->count();
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->explode(' -> ')
                ->map(fn ($pair) => Str::of($pair)
                    ->explode(',')->map(fn ($n) => intval($n))->toArray())
            );
    }

    private function expandLines(Collection $parsed, $includeDiagonal = false): Collection
    {
        return $parsed->map(fn ($line) => $this->expandLine($line, $includeDiagonal))
            ->filter()
            ->flatten(1);
    }

    private function expandLine(Collection $line, $includeDiagonal = false) : ?Collection
    {
        $start = $line->first();
        $end = $line->last();

        // Diagonal line
        if ($start[0] !== $end[0] && $start[1] !== $end[1]) {
            return $includeDiagonal ? $this->diagonalLine($start, $end) : null;
        }

        return $this->straightLine($start, $end);
    }

    private function findSize(Collection $parsed)
    {
        $sizeX = 0;
        $sizeY = 0;

        foreach ($parsed as $line) {
            $start = $line->first();
            $end = $line->last();

            if ($start[0] > $sizeX) {
                $sizeX = $start[0];
            }
            if ($end[0] > $sizeX) {
                $sizeX = $end[0];
            }

            if ($end[1] > $sizeY) {
                $sizeY = $end[1];
            }
            if ($end[1] > $sizeY) {
                $sizeY = $end[1];
            }
        }

        return  [$sizeX, $sizeY];
    }

    private function buildMap(mixed $sizeX, mixed $sizeY): Collection
    {
        $map = collect();
        foreach (range(0, $sizeY) as $y) {
            $xCollection = collect();
            foreach (range(0, $sizeX) as $x) {
                $xCollection->put($x, 0);
            }

            $map->put($y, $xCollection);
        }

        return $map;
    }

    private function fillMap(Collection $map, Collection $points)
    {
        foreach ($points as $point) {
            $value = $map->get($point[0])->get($point[1]);

            $map->get($point[0])->put($point[1], $value + 1);
        }

        return $map;
    }

    /**
     * @param mixed $start
     * @param mixed $end
     * @return Collection
     */
    private function straightLine(mixed $start, mixed $end): Collection
    {
        $points = collect();

        foreach (range($start[0], $end[0]) as $x) {
            foreach (range($start[1], $end[1]) as $y) {
                $points->push([$x, $y]);
            }
        }

        return $points;
    }

    /**
     * @param mixed $start
     * @param mixed $end
     * @return Collection
     */
    private function diagonalLine(mixed $start, mixed $end): Collection
    {
        $moveX = $start[0] > $end[0] ? 1 : -1;
        $moveY = $start[1] > $end[1] ? -1 : 1;

        $points = collect();

        $y = $start[1];
        foreach (range($start[0], $end[0], $moveX) as $x) {
            $points->push([$x, $y]);
            $y =  $y + $moveY;
        }

        return $points;
    }
}
