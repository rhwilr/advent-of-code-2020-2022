<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\DataStructures\Graph\Algorithms\Reachability;
use App\DataStructures\Graph\Graph;
use App\DataStructures\Graph\Vertex;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class Day9 extends AbstractSolver
{
    protected function partOne(string $input)
    {
        $length = $this->getParameter('length', 25);
        $sequence = $this->parseInput($input);

        $preamble = $sequence->take($length);

        return $this->validate($preamble, $sequence->skip($length), $length);
    }

    protected function partTwo(string $input)
    {
        $length = $this->getParameter('length', 25);
        $sequence = $this->parseInput($input);

        $preamble = $sequence->take($length);

        $invalidNumber = $this->validate($preamble, $sequence->skip($length), $length);

        [$first, $last] = $this->findSequence($invalidNumber, $sequence);

        return $first + $last;
    }

    private function parseInput(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => intval($line));
    }

    /**
     * @param Collection $preamble
     * @param Collection $sequence
     * @param int $length
     */
    private function validate(Collection $preamble, Collection $sequence, int $length)
    {
        foreach ($sequence as $item) {
            $sums = $preamble->crossJoin($preamble)
                ->map(fn ($numbers) => $numbers[0] + $numbers[1]);

            $hasItem = $sums->search(function ($sum) use ($item) {
                return $sum === $item;
            });

            if ($hasItem === false) {
                return $item;
            }

            $preamble->shift();
            $preamble->push($item);
        }

        throw new \Exception('Now invalid number found');
    }

    private function findSequence(int $invalidNumber, Collection $sequence)
    {
        while ($sequence->isNotEmpty()) {
            $sum = 0;

            foreach ($sequence as $item) {
                $sum += $item;

                if ($sum > $invalidNumber) {
                    $sequence->shift();
                    break;
                }

                if ($sum === $invalidNumber) {
                    $subset = $sequence->takeUntil($item);
                    return [$subset->min(), $subset->max()];
                }
            }
        }
    }
}
