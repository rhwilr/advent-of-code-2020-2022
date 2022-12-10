<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day9 extends AbstractSolver
{
    private Collection $visited;

    // x, y
    private $head = [0, 0];
    private $segments = [[0, 0],[0, 0],[0, 0],[0, 0],[0, 0],[0, 0],[0, 0],[0, 0]];
    private $tail = [0, 0];

    protected function parse(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(function ($line) {
                [$dir, $steps] = Str::of($line)->explode(' ');

                return [$dir, intval($steps)];
            });
    }

    protected function partOne(string $input)
    {
        $steps = $this->parse($input);

        $this->simulateRope($steps);

        return $this->visited->unique()->count();
    }

    protected function partTwo(string $input)
    {
        $steps = $this->parse($input);

        $this->simulateLongRope($steps);

        return $this->visited->unique()->count();
    }

    private function simulateRope(Collection $steps): int
    {
        $visited = 0;

        $this->visited = collect();
        $this->visited->push(join(',', $this->tail));

        foreach ($steps as $macroStep) {
            [$dir, $macroStepCount] = $macroStep;

            for ($i = 0; $i < $macroStepCount; $i++) {

                $this->moveHead($dir);

                if ($this->moveSegment($this->head, $this->tail)) {
                    $visited++;

                    $this->visited->push(join(',', $this->tail));
                }

            }
        }

        return $visited;
    }


    private function simulateLongRope(Collection $steps): int
    {
        $visited = 0;

        $this->visited = collect();
        $this->visited->push(join(',', $this->tail));

        foreach ($steps as $macroStep) {
            [$dir, $macroStepCount] = $macroStep;

            for ($i = 0; $i < $macroStepCount; $i++) {

                $this->moveHead($dir);

                $this->moveSegment($this->head, $this->segments[0]);
                $this->moveSegment($this->segments[0], $this->segments[1]);
                $this->moveSegment($this->segments[1], $this->segments[2]);
                $this->moveSegment($this->segments[2], $this->segments[3]);
                $this->moveSegment($this->segments[3], $this->segments[4]);
                $this->moveSegment($this->segments[4], $this->segments[5]);
                $this->moveSegment($this->segments[5], $this->segments[6]);
                $this->moveSegment($this->segments[6], $this->segments[7]);

                if ($this->moveSegment($this->segments[7], $this->tail)) {
                    $visited++;

                    $this->visited->push(join(',', $this->tail));
                }

            }
        }

        return $visited;
    }

    private function moveHead(string $dir)
    {
        if ($dir === 'R') {
            $this->head[0]++;
        }

        if ($dir === 'L') {
            $this->head[0]--;
        }

        if ($dir === 'U') {
            $this->head[1]++;
        }

        if ($dir === 'D') {
            $this->head[1]--;
        }
    }

    private function moveSegment($previousSegment, &$currentSegment)
    {
        $dist1 = $previousSegment[0] - $currentSegment[0];
        $dist2 = $previousSegment[1] - $currentSegment[1];

        $distance = max(abs($dist1), abs($dist2));

        if ($previousSegment[1] === $currentSegment[1]) {
            $moveDir = 'H';
        } elseif ($previousSegment[0] === $currentSegment[0]) {
            $moveDir = 'V';
        } else {
            $moveDir = 'D';
        }

        if ($distance > 1) {
            if ($moveDir === 'H') {
                if ($dist1 > 0) {
                    $currentSegment[0]++;
                } else {
                    $currentSegment[0]--;
                }
            } elseif ($moveDir === 'V') {
                if ($dist2 > 0) {
                    $currentSegment[1]++;
                } else {
                    $currentSegment[1]--;
                }
            } elseif ($moveDir === 'D') {
                if ($dist1 > 0) {
                    $currentSegment[0]++;
                } else {
                    $currentSegment[0]--;
                }
                if ($dist2 > 0) {
                    $currentSegment[1]++;
                } else {
                    $currentSegment[1]--;
                }
            }
            return true;
        }

        return false;
    }
}
