<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day14 extends AbstractSolver
{
    private Collection $template;
    private Collection $insertions;

    protected function partOne(string $input)
    {
        return $this->parseInput($input)
            ->insertionSteps(10)
            ->calculateScore();
    }

    protected function partTwo(string $input)
    {
        return $this->parseInput($input)
            ->insertionSteps(10)
            ->calculateScore();
    }

    protected function parseInput(string $input)
    {
        [$template, $insertions] = Str::of($input)
            ->explode("\n\n");

        $this->template = Str::of($template)
            ->split(1);

        $this->insertions = Str::of($insertions)
            ->trim()
            ->explode("\n")
            ->mapWithKeys(function ($line, $key) {
                $parts = Str::of($line)->explode(' -> ')->toArray();

                return [$parts[0] => $parts[1]];
            });

        return $this;
    }

    private function insertionSteps(int $count)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->insertionStep();
        }

        return $this;
    }

    private function insertionStep()
    {
        $lastElement = $this->template->last();

        $this->template = $this->template->sliding(2)
            ->map(function (Collection $pair) {
                // Is it possible that there is no insertion?
                $insert = $this->insertions->get($pair->join(''));

                return [$pair->first(), $insert];
            })
            ->flatten()
            ->push($lastElement);

        return $this;
    }

    public function calculateScore()
    {
        $counts = $this->template
            ->countBy()
            ->sort();

        return $counts->last() - $counts->first();
    }
}
