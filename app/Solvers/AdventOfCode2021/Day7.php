<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

class Day6 extends AbstractSolver
{
    private const REPRODUCTION_TIMER = 6;
    private const INIT_TIMER = 8;

    protected function partOne(string $input)
    {
        return $this->simulateForDays($input, 80);
    }

    protected function partTwo(string $input)
    {
        return $this->simulateForDays($input, 256);
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode(",")
            ->map(fn ($n) => intval($n));
    }

    private function ageByOneDay(Collection $school)
    {
        $fishReproducing = $school->shift();

        $school->put(self::REPRODUCTION_TIMER, $school->get(self::REPRODUCTION_TIMER, 0) + $fishReproducing);
        $school->put(self::INIT_TIMER, $fishReproducing);

        return $school;
    }

    private function convertIntoAgeBuckets(Collection $fish)
    {
        $buckets = collect(range(0, self::INIT_TIMER));

        return $buckets->map(function ($item, $key) use ($fish) {
            return $fish->filter(fn ($n) => $n === $key)->count();
        });
    }

    /**
     * @param string $input
     * @return mixed
     */
    protected function simulateForDays(string $input, int $days): mixed
    {
        $fish = $this->parseInput($input);

        $school = $this->convertIntoAgeBuckets($fish);

        foreach (range(1, $days) as $day) {
            $school = $this->ageByOneDay($school);
        }

        return $school->sum();
    }
}
