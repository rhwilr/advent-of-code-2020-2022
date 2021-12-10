<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day9;
use Tests\TestCase;

class Day9Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day9::make()->setInput(<<<TXT
2199943210
3987894921
9856789892
8767896789
9899965678
TXT
        );

        $this->assertSame(15, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day9::make();

        $this->assertSame(475, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day9::make()->setInput(<<<TXT
2199943210
3987894921
9856789892
8767896789
9899965678
TXT
        );

        $this->assertSame(1134, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day9::make();

        $this->assertSame(1092012, $day->solvePartTwo());
    }
}
