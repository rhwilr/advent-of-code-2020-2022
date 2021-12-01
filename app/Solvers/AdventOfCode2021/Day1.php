<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Str;
use RuntimeException;

class Day1 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->map(fn ($item) => intval($item))
            ->sliding(2)
            ->map(fn ($item) => $item->last() > $item->first())
            ->filter()
            ->count();
    }

    protected function partTwo(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->map(fn ($item) => intval($item))
            ->sliding(3)
            ->map(fn ($item) => $item->sum())
            ->sliding(2)
            ->map(fn ($item) => $item->last() > $item->first())
            ->filter()
            ->count();
    }
}
