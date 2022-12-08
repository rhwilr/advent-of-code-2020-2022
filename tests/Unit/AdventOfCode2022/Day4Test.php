<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day4;
use Tests\TestCase;

class Day4Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day4::make()->setInput(<<<TXT
2-4,6-8
2-3,4-5
5-7,7-9
2-8,3-7
6-6,4-6
2-6,4-8
TXT);

        $this->assertSame(2, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day4::make();

        $this->assertSame(515, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day4::make()->setInput(<<<TXT
2-4,6-8
2-3,4-5
5-7,7-9
2-8,3-7
6-6,4-6
2-6,4-8
TXT);

        $this->assertSame(4, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day4::make();

        $this->assertSame(883, $day->solvePartTwo());
    }
}
