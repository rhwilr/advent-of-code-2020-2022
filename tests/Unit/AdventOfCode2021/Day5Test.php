<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day5;
use Tests\TestCase;

class Day5Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day5::make()->setInput(<<<TXT
0,9 -> 5,9
8,0 -> 0,8
9,4 -> 3,4
2,2 -> 2,1
7,0 -> 7,4
6,4 -> 2,0
0,9 -> 2,9
3,4 -> 1,4
0,0 -> 8,8
5,5 -> 8,2
TXT
        );

        $this->assertSame(5, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day5::make();

        $this->assertSame(8060, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day5::make()->setInput(<<<TXT
0,9 -> 5,9
8,0 -> 0,8
9,4 -> 3,4
2,2 -> 2,1
7,0 -> 7,4
6,4 -> 2,0
0,9 -> 2,9
3,4 -> 1,4
0,0 -> 8,8
5,5 -> 8,2
TXT
        );

        $this->assertSame(12, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day5::make();

        $this->assertSame(21577, $day->solvePartTwo());
    }
}
