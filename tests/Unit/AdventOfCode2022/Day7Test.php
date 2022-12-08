<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day7;
use Tests\TestCase;

class Day7Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day7::makeExample();

        $this->assertSame(95437, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day7::make();

        $this->assertSame(1297683, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day7::makeExample();

        $this->assertSame(24933642, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day7::make();

        $this->assertSame(5756764, $day->solvePartTwo());
    }
}
