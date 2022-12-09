<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day8 extends AbstractSolver
{
    private $count = 0;

    protected function parse(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => array_map('intval', str_split($line)))
            ->tap(function ($map) {
                $this->count = count($map);
            })
            ->toArray();
    }

    protected function partOne(string $input)
    {
        $map = $this->parse($input);

        return $this->countVisible($map);
    }

    protected function partTwo(string $input)
    {
        $map = $this->parse($input);

        return $this->findScenicTree($map);
    }

    private function countVisible(array $map)
    {
        $seen = 0;

        $originalMap = json_decode(json_encode($map));

        for ($i = 0; $i < $this->count; $i++) {
            $seen += $this->scanLToR($map, $originalMap, $i);
            $seen += $this->scanRToL($map, $originalMap, $i);
        }

        for ($i = 0; $i < $this->count; $i++) {
            $seen += $this->scanTToB($map, $originalMap, $i);
            $seen += $this->scanBToT($map, $originalMap, $i);
        }

        return $seen;
    }

    private function scanLToR(array &$map, array $originalMap, int $row): int
    {
        $seen = 0;
        $max = -1;

        for ($i = 0; $i < $this->count; $i++) {
            $tree = $originalMap[$row][$i];

            if ($tree > $max) {
                if ($map[$row][$i] !== -1) {
                    $seen++;
                    $map[$row][$i] = -1;
                }
                $max = $tree;
            }
        }

        return $seen;
    }

    private function scanRToL(array &$map, array $originalMap, int $row): int
    {
        $seen = 0;
        $max = -1;

        for ($i = $this->count - 1; $i >= 0; $i--) {
            $tree = $originalMap[$row][$i];

            if ($tree > $max) {
                if ($map[$row][$i] !== -1) {
                    $seen++;
                    $map[$row][$i] = -1;
                }
                $max = $tree;
            }
        }

        return $seen;
    }

    private function scanTToB(array &$map, array $originalMap, int $col): int
    {
        $seen = 0;
        $max = -1;

        for ($i = 0; $i < $this->count; $i++) {
            $tree = $originalMap[$i][$col];

            if ($tree > $max) {
                if ($map[$i][$col] !== -1) {
                    $seen++;
                    $map[$i][$col] = -1;
                }
                $max = $tree;
            }
        }

        return $seen;
    }

    private function scanBToT(array &$map, array $originalMap, int $col): int
    {
        $seen = 0;
        $max = -1;

        for ($i = $this->count - 1; $i >= 0; $i--) {
            $tree = $originalMap[$i][$col];

            if ($tree > $max) {
                if ($map[$i][$col] !== -1) {
                    $seen++;
                    $map[$i][$col] = -1;
                }
                $max = $tree;
            }
        }

        return $seen;
    }

    private function findScenicTree(array $map)
    {
        $max = 0;

        for ($i = 0; $i < $this->count; $i++) {
            for ($j = 0; $j < $this->count; $j++) {
                $tree = $map[$i][$j];

                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;

                // Left
                for ($k = $j - 1; $k >= 0; $k--) {
                    if ($map[$i][$k] < $tree) {
                        $a++;
                    }
                    if ($map[$i][$k] >= $tree) {
                        $a++;
                        break;
                    }
                }

                // Right
                for ($k = $j + 1; $k <= $this->count - 1; $k++) {
                    if ($map[$i][$k] < $tree) {
                        $b++;
                    }
                    if ($map[$i][$k] >= $tree) {
                        $b++;
                        break;
                    }
                }

                // Top
                for ($k = $i - 1; $k >= 0; $k--) {
                    if ($map[$k][$j] < $tree) {
                        $c++;
                    }
                    if ($map[$k][$j] >= $tree) {
                        $c++;
                        break;
                    }
                }

                // Bottom
                for ($k = $i + 1; $k <= $this->count - 1; $k++) {
                    if ($map[$k][$j] < $tree) {
                        $d++;
                    }
                    if ($map[$k][$j] >= $tree) {
                        $d++;
                        break;
                    }
                }


                $score = $a * $b * $c * $d;

                if ($max < $score) {
                    $max = $score;
                }
            }
        }

        return $max;
    }
}
