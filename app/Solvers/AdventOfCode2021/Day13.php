<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day13 extends AbstractSolver
{
    private Collection $points;
    private Collection $folds;
    private Collection $map;

    protected function partOne(string $input)
    {
        $this->parseInput($input)
            ->buildMap()
            ->fold($this->folds->first());

        return $this->map->flatten()->filter(fn ($n) => !!$n)
            ->count();
    }

    protected function partTwo(string $input)
    {
        $this->parseInput($input)
            ->buildMap()
            ->applyFolds();

        // Print the code
        // $this->print();

        return $this->map->flatten()->filter(fn ($n) => !!$n)
            ->count();
    }

    protected function parseInput(string $input)
    {
        [$points, $folds] = Str::of($input)
            ->explode("\n\n");

        $this->points = Str::of($points)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->explode(',')
                ->map(fn($n) => intval($n))
            );

        $this->folds = Str::of($folds)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->replace('fold along ', '')
                ->explode('=')
                ->map(function($i) {
                    if (in_array($i, ['x', 'y'])) {
                        return $i;
                    }

                    return intval($i);
                })
            );

        return $this;
    }

    private function buildMap()
    {
        $maxX = $this->points->map(fn ($n) => $n[0])
            ->max();
        $maxY = $this->points->map(fn ($n) => $n[1])
            ->max();

        $this->map = collect(array_fill(0, $maxY + 1, null))
            ->map(fn ($row) => collect(array_fill(0, $maxX + 1, false)));

        foreach ($this->points as $point) {
            $x = $point[0];
            $y = $point[1];

            $row = $this->map->get($y)
                ->put($x, true)
                ->sortKeys();

            $this->map->put($y, $row);
        }

        $this->map = $this->map->sortKeys();

        return $this;
    }

    private function applyFolds()
    {
        foreach ($this->folds as $fold) {
            $this->fold($fold);
        }
    }

    private function fold(Collection $fold)
    {
        $direction = $fold[0];
        $position = $fold[1];

        if ($direction === 'y') {
            return $this->foldY($position);
        }

        return $this->foldX($position);
    }

    private function foldY(int $position)
    {
        $upper = $this->map->take($position);
        $lower = $this->map->skip($position);

        $lower = $lower->reverse()->values();

        $this->map = collect();

        foreach ($upper as $key => $row) {
            $lowerRow = $lower->get($key);

            $merged = $row->map(function ($item, $key) use ($lowerRow) {
                if ($item) {
                    return $item;
                }

                return $lowerRow->get($key, false);
            });

            $this->map->put($key, $merged);
        }
    }

    private function foldX(mixed $position)
    {
        foreach ($this->map as $key => $row) {
            $first = $row->take($position);
            $second = $row->skip($position);

            $second = $second->reverse()->values();

            $merged = $first->map(function ($item, $key) use ($second) {
                if ($item) {
                    return $item;
                }

                return $second->get($key, false);
            });

            $this->map->put($key, $merged);
        }
    }

    private function print()
    {
        echo "\n";

        foreach ($this->map as $row) {
            foreach ($row as $n) {
                echo $n ? "#" : ' ';
            }
            echo "\n";
        }
    }
}
