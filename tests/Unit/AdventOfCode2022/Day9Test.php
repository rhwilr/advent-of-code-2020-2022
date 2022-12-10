<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day9;
use Tests\TestCase;

class Day9Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day9::makeExample();

        $this->assertSame(13, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day9::make();

        $this->assertSame(6023, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day9::makeExample();

        $this->assertSame(1, $day->solvePartTwo());

        $day = Day9::makeExample(2);

        $this->assertSame(36, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day9::make();

        $this->assertSame(2533, $day->solvePartTwo());
    }
}
