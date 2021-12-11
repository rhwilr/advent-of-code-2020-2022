<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day11;
use Tests\TestCase;

class Day11Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day11::make()->setInput(<<<TXT
5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526
TXT
        );

        $this->assertSame(1656, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day11::make();

        $this->assertSame(1617, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day11::make()->setInput(<<<TXT
5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526
TXT
        );

        $this->assertSame(195, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day11::make();

        $this->assertSame(258, $day->solvePartTwo());
    }
}
