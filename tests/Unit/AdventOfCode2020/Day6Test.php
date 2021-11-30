<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day6;
use Tests\TestCase;

class Day6Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day6::make()->setInput(<<<TXT
abc

a
b
c

ab
ac

a
a
a
a

b
TXT);

        $this->assertSame(11, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day6::make();

        $this->assertSame(7120, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day6::make()->setInput(<<<TXT
abc

a
b
c

ab
ca

a
a
a
a

b
TXT);

        $this->assertSame(6, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day6::make();

        $this->assertSame(3570, $day->solvePartTwo());
    }
}
