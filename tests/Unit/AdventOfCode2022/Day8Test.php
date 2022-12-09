<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day8;
use Tests\TestCase;

class Day8Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day8::makeExample();

        $this->assertSame(21, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day8::make();

        $this->assertSame(1801, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day8::makeExample();

        $this->assertSame(8, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day8::make();

        $this->assertSame(209880, $day->solvePartTwo());
    }
}
