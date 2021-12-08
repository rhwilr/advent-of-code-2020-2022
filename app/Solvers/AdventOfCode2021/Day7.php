<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

class Day7 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        $crabs = $this->parseInput($input);

        $optimum = $crabs->median();

        return $crabs
            ->map(fn ($position) => abs($position - $optimum))
            ->sum();
    }

    protected function partTwo(string $input)
    {
        $crabs = $this->parseInput($input);

        $median = $crabs->median();

        return $this->optimizeGradientDecent($median, $crabs);
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode(",")
            ->map(fn ($n) => intval($n));
    }

    private function optimizeGradientDecent(int $median, Collection $crabs)
    {
        $moveDirection = 1;

        $best = $this->calculateFuel($crabs, $median);
        $guess = $median + $moveDirection;

        $previousBest = null;

        // Do at least 5 iteration, then continue as long as we still find better values
        while ($best !== $previousBest) {
            $previousBest = $best;

            $fuel = $this->calculateFuel($crabs, $guess);

            if ($fuel > $best) {
                $moveDirection = $moveDirection * -1;
            } else {
                $best = $fuel;
            }

            $guess += $moveDirection;
        }

        return $best;
    }

    /**
     * @param Collection $crabs
     * @param $guess
     * @return mixed
     */
    private function calculateFuel(Collection $crabs, $guess): mixed
    {
        return $crabs
            ->map(function ($position) use ($guess) {
                $diff = abs($position - $guess);

                return $diff * (1 + $diff) / 2;
            })
            ->sum();
    }
}
