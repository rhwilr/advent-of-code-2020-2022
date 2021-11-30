<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use AdventOfCode2020\Day3\MapObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day3 extends AbstractSolver
{
    private function solver(string $input, $rightMove, $downMove)
    {
        return Str::of($input)
            // Split into lines
            ->explode("\n")
            // Map the line into a list of booleans indicating if it is a tree or not
            ->map(function ($line) {
                return Str::of($line)
                    ->split('//')
                    ->filter()
                    ->map(fn($input) => $input === '#');
            })
            // Skip rows based on move
            ->filter(fn(Collection $line, $rowIndex) => $rowIndex % $downMove === 0)
            ->values()
            // Get the Object from the map we are currently on
            ->map(function (Collection $line, $rowIndex) use ($rightMove) {
                $modulus = $line->count();

                $rightPosition = ($rightMove * ($rowIndex)) % $modulus + 1;

                return $line->get($rightPosition);
            })
            // Keep only the trees
            ->filter(fn($isTree) => $isTree)
            // Count how many trees we encountered
            ->count();
    }

    protected function partOne(string $input)
    {
        return $this->solver($input, 3, 1);
    }

    protected function partTwo(string $input)
    {
        return $this->solver($input, 1, 1) *
            $this->solver($input, 3, 1) *
            $this->solver($input, 5, 1) *
            $this->solver($input, 7, 1) *
            $this->solver($input, 1, 2);
    }
}
