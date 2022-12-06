<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day6;
use Tests\TestCase;

class Day6Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day6::makeExample();

        $this->assertSame([7, 5, 6, 10, 11], $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day6::make();

        $this->assertSame([1093], $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day6::makeExample();

        $this->assertSame([19, 23, 23, 29, 26], $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day6::make();

        $this->assertSame([3534], $day->solvePartTwo());
    }
}
