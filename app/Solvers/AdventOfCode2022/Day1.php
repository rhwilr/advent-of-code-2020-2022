<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

class Day1 extends AbstractSolver
{
    protected function parse(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n\n")
            ->map(fn ($elves) => Str::of($elves)
                ->explode("\n")
                ->map(fn ($item) => intval($item))
                ->sum()
            );
    }

    protected function partOne(string $input)
    {
        return $this->parse($input)
            ->max();
    }

    protected function partTwo(string $input)
    {
        return $this->parse($input)
            ->sortDesc()
            ->take(3)
            ->sum();
    }
}
