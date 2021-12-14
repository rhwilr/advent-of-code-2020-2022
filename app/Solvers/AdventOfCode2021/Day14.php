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

    private Collection $pairs;
    private Collection $counts;

    protected function partOne(string $input)
    {
        return $this->parseInput($input)
            ->prepare()
            ->insertionSteps(10)
            ->calculateScore();
    }

    protected function partTwo(string $input)
    {
        return $this->parseInput($input)
            ->prepare()
            ->insertionSteps(40)
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
        $nextPairs = collect();

        $this->pairs->each(function ($count, $pair) use ($nextPairs) {
            $insert = $this->insertions->get($pair);
            $letters = Str::of($pair)->split(1);

            $this->counts->put($insert, $this->counts->get($insert, 0) + $count);

            $p1 = $letters->first() . $insert;
            $p2 = $insert . $letters->last();

            $nextPairs->put($p1, $nextPairs->get($p1, 0) + $count);
            $nextPairs->put($p2, $nextPairs->get($p2, 0) + $count);
        });

        $this->pairs = $nextPairs;

        return $this;
    }

    public function calculateScore()
    {
        $counts = $this->counts
            ->sort();

        return $counts->last() - $counts->first();
    }

    private function prepare()
    {
        $this->pairs = $this->template
            ->sliding(2)
            ->map(fn ($pair) => $pair->join(''))
            ->countBy();

        $this->counts = $this->template->countBy();

        return $this;
    }
}
