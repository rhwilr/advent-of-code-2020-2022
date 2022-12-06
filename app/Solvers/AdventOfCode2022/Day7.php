<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day7 extends AbstractSolver
{
    private Stacks $stacks;

    protected function parse(string $input)
    {
        return Str::of($input)
            ->explode("\n");
    }

    protected function partOne(string $input)
    {
        $this->parse($input);
    }

    protected function partTwo(string $input)
    {
        $this->parse($input);
    }
}
