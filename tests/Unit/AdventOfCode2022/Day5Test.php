<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day5;
use Tests\TestCase;

class Day5Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day5::makeExample();

        $this->assertSame('CMZ', $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day5::make();

        $this->assertSame('VWLCWGSDQ', $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day5::makeExample();

        $this->assertSame('MCD', $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day5::make();

        $this->assertSame('TCGLQSLPW', $day->solvePartTwo());
    }
}
