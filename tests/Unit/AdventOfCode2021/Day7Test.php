<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day2;
use Tests\TestCase;

class DayTemplate extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $this->markTestSkipped();
        $day = Day2::make()->setInput(<<<TXT

TXT
        );

        $this->assertSame(null, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $this->markTestSkipped();
        $day = Day2::make();

        $this->assertSame(null, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $this->markTestSkipped();
        $day = Day2::make()->setInput(<<<TXT

TXT
        );

        $this->assertSame(null, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $this->markTestSkipped();
        $day = Day2::make();

        $this->assertSame(null, $day->solvePartTwo());
    }
}
