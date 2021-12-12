<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\DataStructures\SevenSegment\SevenSegment;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day11 extends AbstractSolver
{
    private Collection $map;

    protected function partOne(string $input)
    {
        $this->map = $this->parseInput($input);

        return $this->simulateFlashes(100);
    }

    protected function partTwo(string $input)
    {
        $this->map = $this->parseInput($input);

        $iterations = 1;

        while (true) {
            $this->simulateStep();

            if ($this->isSynchronized()) {
                return $iterations;
            }

            $iterations++;
        }
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->split(1)
                ->map(fn ($n) => intval($n))
            );
    }

    private function simulateFlashes(int $iterations): int
    {
        $flashes = 0;

        foreach (range(1, $iterations) as $iteration) {
            $flashes += $this->simulateStep();
        }

        return $flashes;
    }

    private function simulateStep(): int
    {
        $flashes = 0;

        // tick all octopus
        $this->map = $this->map->map(function ($line) {
            return $line->map(function ($octopus) {
                return $octopus + 1;
            });
        });

        // flash charged octopus
        foreach ($this->map as $y => $line) {
            foreach ($line as $x => $octopus) {
                if ($octopus > 9) {
                    $this->flashOctopus($x, $y);
                }
            }
        }

        // reset flashing octopus to 0
        foreach ($this->map as $y => $line) {
            foreach ($line as $x => $octopus) {
                if ($octopus >= 1000) {
                    $this->update($y, $x, 0);
                    $flashes++;
                }
            }
        }

        return $flashes;
    }

    private function flashOctopus(int $x, int $y)
    {
        $value = $this->map->get($y)?->get($x);

        // If it has flashed, it will not flash again
        if ($value >= 1000) {
            return;
        }

        $this->update($y, $x, 1000);

        $this->incrementAndMayFlash($y - 1, $x - 1);
        $this->incrementAndMayFlash($y - 1, $x);
        $this->incrementAndMayFlash($y - 1, $x + 1);
        $this->incrementAndMayFlash($y, $x - 1);
        $this->incrementAndMayFlash($y, $x + 1);
        $this->incrementAndMayFlash($y + 1, $x - 1);
        $this->incrementAndMayFlash($y + 1, $x);
        $this->incrementAndMayFlash($y + 1, $x + 1);
    }

    /**
     * @param int $y
     * @param int $x
     * @param int $value
     * @return void
     */
    private function update(int $y, int $x, int $value): void
    {
        $line = $this->map->get($y);

        $line->put($x, $value);

        $this->map->put($y, $line);
    }

    private function increment(int $y, int $x)
    {
        $value = $this->map->get($y)?->get($x);

        if (!is_null($value)) {
            $this->update($y, $x, $value + 1);
        }
    }

    private function incrementAndMayFlash(int $y, int $x)
    {
        $this->increment($y, $x);

        $value = $this->map->get($y)?->get($x);

        if ($value > 9) {
            $this->flashOctopus($x, $y);
        }
    }

    private function isSynchronized(): bool
    {
        return $this->map->flatten()->every(function ($value) {
            return $value === 0;
        });
    }
}
