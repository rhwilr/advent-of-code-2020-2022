<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day4;
use Tests\TestCase;

class Day4Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day4::makeExample();

        $this->assertSame('CMZ', $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day4::make();

        $this->assertSame('VWLCWGSDQ', $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day4::makeExample();

        $this->assertSame('MCD', $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day4::make();

        $this->assertSame('TCGLQSLPW', $day->solvePartTwo());
    }
}
