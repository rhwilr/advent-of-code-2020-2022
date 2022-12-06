<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day6 extends AbstractSolver
{
    private Stacks $stacks;

    protected function parse(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->filter();
    }

    protected function partOne(string $input)
    {
        return collect($this->parse($input))
            ->map(fn($buffer) => $this->startOfMarker($buffer, 4))
            ->toArray();
    }

    protected function partTwo(string $input)
    {
        return collect($this->parse($input))
            ->map(fn($buffer) => $this->startOfMarker($buffer, 14))
            ->toArray();
    }


    private function startOfMarker(string $buffer, int $markerLenght): int
    {
        $bytes = str_split($buffer);
        $length = strlen($buffer);

        $compareBuffer = collect();

        // Fill buffer with first bytes
        for ($i = 0; $i < $markerLenght; $i ++) {
            $compareBuffer->push($bytes[$i]);
        }

        // Find start of the marker
        for ($i = $markerLenght; $i < $length; $i ++) {
            if ($compareBuffer->duplicates()->count() === 0) {
                return $i;
            }

            $compareBuffer->shift();
            $compareBuffer->push($bytes[$i]);
        }
    }
}
