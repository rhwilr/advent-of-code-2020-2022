<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\DataStructures\Graph\Algorithms\Reachability;
use App\DataStructures\Graph\Graph;
use App\DataStructures\Graph\Vertex;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class Day10 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        $adapters = $this->parseInput($input);
        $deviceJoltage = $adapters->max() + 3;

        $diffs = $this->validateSequence($adapters, 0, $deviceJoltage);

        $diffs1 = $diffs->filter(fn ($diff) => $diff === 1)->count();
        $diffs3 = $diffs->filter(fn ($diff) => $diff === 3)->count();

        return $diffs1 * $diffs3;
    }

    protected function partTwo(string $input)
    {
        $adapters = $this->parseInput($input);
        $deviceJoltage = $adapters->max() + 3;

        $adapters->push($deviceJoltage)->prepend(0);

        return $this->findCombinations($adapters, 0);
    }

    private function parseInput(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => intval($line))
            ->sort()
            ->values();
    }

    private function validateSequence(Collection $adapters, int $startJoltage, int $deviceJoltage)
    {
        $previous = $startJoltage;
        $adapters->push($deviceJoltage);

        $diff = collect();

        foreach ($adapters as $adapter) {
            throw_if($previous < $adapter-3,
                __('Sequence not valid, Adapter :adapter can not take :previous jolts', [
                    'adapter' => $adapter,
                    'previous' => $previous,
                ]));

            throw_if($previous > $adapter,
                __('Sequence not valid, Previous :previous is larger than :adapter', [
                    'adapter' => $adapter,
                    'previous' => $previous,
                ]));

            $diff->push($adapter - $previous);

            $previous = $adapter;
        }

        return $diff;
    }

    private function findCombinations(Collection $adapters, int $startIndex)
    {
        // caching is absolutely essential for this.
        // without this cache, part 2 will take hours.
        // using a cache it takes a fraction of a section.
        if (Cache::has('day10-'. $startIndex)) {
            return Cache::get('day10-'. $startIndex);
        }

        if ($startIndex >= $adapters->count() - 1) {
            return 1;
        }

        $sum = 0;
        foreach (range($startIndex + 1, min($startIndex + 4, $adapters->count()-1)) as $i) {
            if ($adapters->get($i) - $adapters->get($startIndex) <= 3) {

                $sum += $this->findCombinations($adapters, $i);
            }
        }

        Cache::put('day10-'. $startIndex, $sum);

        return $sum;
    }
}
