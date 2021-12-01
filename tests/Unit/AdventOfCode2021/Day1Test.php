<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day1;
use Tests\TestCase;

class Day1Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day1::make()->setInput(<<<TXT
199
200
208
210
200
207
240
269
260
263
TXT);

        $this->assertSame(7, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day1::make();

        $this->assertSame(1583, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day1::make()->setInput(<<<TXT
199
200
208
210
200
207
240
269
260
263
TXT);

        $this->assertSame(5, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day1::make();

        $this->assertSame(1627, $day->solvePartTwo());
    }
}
