<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day13;
use Tests\TestCase;

class Day13Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day13::make()->setInput(<<<TXT
6,10
0,14
9,10
0,3
10,4
4,11
6,0
6,12
4,1
0,13
10,12
3,4
3,0
8,4
1,10
2,14
8,10
9,0

fold along y=7
fold along x=5
TXT
        );

        $this->assertSame(17, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day13::make();

        $this->assertSame(671, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day13::make()->setInput(<<<TXT
6,10
0,14
9,10
0,3
10,4
4,11
6,0
6,12
4,1
0,13
10,12
3,4
3,0
8,4
1,10
2,14
8,10
9,0

fold along y=7
fold along x=5
TXT
        );

        $this->assertSame(16, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day13::make();

        $this->assertSame(97, $day->solvePartTwo());
    }
}
