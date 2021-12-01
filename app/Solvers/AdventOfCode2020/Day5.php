<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Day5 extends AbstractSolver
{
    public function calculateSeatId(string $input): int
    {
        $row = (int)(string)Str::of($input)->substr(0, 7)
            ->replace('B', 1)
            ->replace('F', 0)
            ->trim()
            ->pipe('bindec');

        $column = (int)(string)Str::of($input)->substr(7)
            ->replace('R', 1)
            ->replace('L', 0)
            ->trim()
            ->pipe('bindec');

        return $row * 8 + $column;
    }

    protected function partOne(string $input)
    {
        return Str::of($input)
            // Split into lines
            ->explode("\n")
            ->filter()
            ->map(fn ($seat) => $this->calculateSeatId($seat))
            ->max();
    }

    protected function partTwo(string $input)
    {
        $seats = Str::of($input)
            // Split into lines
            ->explode("\n")
            ->filter()
            ->map(fn ($seat) => $this->calculateSeatId($seat));

        return collect(range($seats->min(), $seats->max()))
            ->diff($seats)
            ->first();
    }
}
