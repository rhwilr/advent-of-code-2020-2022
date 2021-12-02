<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day2;
use Tests\TestCase;

class Day2Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day2::make()->setInput(<<<TXT
forward 5
down 5
forward 8
up 3
down 8
forward 2
TXT
        );

        $this->assertSame(150, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day2::make();

        $this->assertSame(1855814, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day2::make()->setInput(<<<TXT
forward 5
down 5
forward 8
up 3
down 8
forward 2
TXT
        );

        $this->assertSame(900, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day2::make();

        $this->assertSame(1845455714, $day->solvePartTwo());
    }
}
