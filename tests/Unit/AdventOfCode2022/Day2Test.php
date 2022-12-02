<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day2;
use Tests\TestCase;

class Day2Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day2::make()->setInput(<<<TXT
A Y
B X
C Z
TXT);

        $this->assertSame(15, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day2::make();

        $this->assertSame(14297, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day2::make()->setInput(<<<TXT
A Y
B X
C Z
TXT);

        $this->assertSame(12, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day2::make();

        $this->assertSame(10498, $day->solvePartTwo());
    }
}
