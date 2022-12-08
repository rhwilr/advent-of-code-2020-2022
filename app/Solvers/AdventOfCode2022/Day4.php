<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day4 extends AbstractSolver
{
    protected function parse(string $input): Collection
    {
        return Str::of(trim($input))
            ->explode("\n")
            ->map(function ($line) {
                return Str::of($line)
                    ->split("/[-,]+/")
                    ->map(fn ($item) => intval($item))
                    ->chunk(2);
            });
    }

    protected function partOne(string $input)
    {
        return $this->parse($input)
            ->filter(function (Collection $line) {
                [$e1, $e2] = $line->values();

                return $this->sectionContains($e1, $e2) || $this->sectionContains($e2, $e1);
            })
            ->count();
    }

    protected function partTwo(string $input)
    {
        return $this->parse($input)
            ->filter(function (Collection $line) {
                [$e1, $e2] = $line->values();

                return $this->sectionOverlap($e1, $e2) && $this->sectionOverlap($e2, $e1);
            })
            ->count();
    }

    // Returns true if the first section is contained within the second section
    private function sectionContains(Collection $e1, Collection $e2)
    {
        [$startE1, $endE1] = $e1->values();
        [$startE2, $endE2] = $e2->values();

        return $startE1 >= $startE2 && $endE1 <= $endE2;
    }


    // Returns true if the sections have any overlap
    private function sectionOverlap(Collection $e1, Collection $e2)
    {
        [$startE1, $endE1] = $e1->values();
        [$startE2, $endE2] = $e2->values();

        return !($startE1 <= $endE1 && $endE1 < $startE2 && $startE2 <= $endE2);
    }
}
