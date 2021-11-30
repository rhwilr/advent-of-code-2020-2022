<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day11;
use Tests\TestCase;

class Day11Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day11::make()->setInput(<<<TXT
L.LL.LL.LL
LLLLLLL.LL
L.L.L..L..
LLLL.LL.LL
L.LL.LL.LL
L.LLLLL.LL
..L.L.....
LLLLLLLLLL
L.LLLLLL.L
L.LLLLL.LL
TXT
        );

        $this->assertSame(37, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day11::make();

        $this->assertSame(2319, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day11::make()->setInput(<<<TXT
L.LL.LL.LL
LLLLLLL.LL
L.L.L..L..
LLLL.LL.LL
L.LL.LL.LL
L.LLLLL.LL
..L.L.....
LLLLLLLLLL
L.LLLLLL.L
L.LLLLL.LL
TXT
        );

        $this->assertSame(26, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day11::make();

        $this->assertSame(2117, $day->solvePartTwo());
    }
}
