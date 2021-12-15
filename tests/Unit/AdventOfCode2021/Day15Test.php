<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day15;
use Tests\TestCase;

class Day15Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day15::make()->setInput(<<<TXT
1163751742
1381373672
2136511328
3694931569
7463417111
1319128137
1359912421
3125421639
1293138521
2311944581
TXT
        );

        $this->assertSame(40, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day15::make();

        $this->assertSame(null, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $this->markTestSkipped();
        $day = Day15::make()->setInput(<<<TXT

TXT
        );

        $this->assertSame(null, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $this->markTestSkipped();
        $day = Day15::make();

        $this->assertSame(null, $day->solvePartTwo());
    }
}
