<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Str;
use RuntimeException;

class Day2 extends AbstractSolver
{
    private int $position = 0;
    private int $depth = 0;
    private int $aim = 0;

    protected function partOne(string $input)
    {
        $this->parseInput($input)
            ->each(fn ($line) => $this->executePartOneCommand(...$line));

        return $this->position * $this->depth;
    }

    protected function partTwo(string $input)
    {
        $this->parseInput($input)
            ->each(fn ($line) => $this->executePartTwoCommand(...$line));

        return $this->position * $this->depth;
    }

    protected function parseInput(string $input): \Illuminate\Support\Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => Str::of($line)->explode(' '));
    }


    private function executePartOneCommand(string $command, string $parameter)
    {
        $parameter = intval($parameter);

        if ($command === 'forward') {
            $this->position += $parameter;
            return;
        }

        if ($command === 'down') {
            $this->depth += $parameter;
            return;
        }

        if ($command === 'up') {
            $this->depth -= $parameter;
            return;
        }
    }

    private function executePartTwoCommand(string $command, string $parameter)
    {
        $parameter = intval($parameter);

        if ($command === 'forward') {
            $this->position += $parameter;
            $this->depth += $this->aim * $parameter;
            return;
        }

        if ($command === 'down') {
            $this->aim += $parameter;
            return;
        }

        if ($command === 'up') {
            $this->aim -= $parameter;
            return;
        }
    }
}
