<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Day6 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        return Str::of($input)
            // Split into groups
            ->explode("\n\n")
            ->map(fn ($i) => (string)Str::of($i)->trim())
            ->map(function ($group) {
                return Str::of($group)
                    ->split('//')
                    ->map(fn ($i) => (string)Str::of($i)->trim())
                    ->filter()
                    ->unique();
            })
            ->map(fn(Collection $votes) => $votes->count())
            ->reduce(function ($carry, $item) {
                return $carry + $item;
            });
    }

    protected function partTwo(string $input)
    {
        return Str::of($input)
            // Split into groups
            ->explode("\n\n")
            ->map(fn ($i) => (string)Str::of($i)->trim())
            ->map(function ($group) {
                return Str::of($group)
                    ->explode("\n")
                    ->map(fn ($i) => Str::of($i)
                        ->split('//')
                        ->filter()
                    )
                    ->reduce(function (?Collection $carry, Collection $group) {
                        return is_null($carry) ? $group : $carry->intersect($group);
                    });
            })
            ->map(fn(Collection $votes) => $votes->count())
            ->reduce(function ($carry, $item) {
                return $carry + $item;
            });
    }
}
