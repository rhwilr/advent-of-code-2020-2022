<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day2;
use Tests\TestCase;

class Day2Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day2::make()->setInput(<<<TXT
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
15-16 h: hhhhhhhhhhhhhhbsh
1-4 h: hhhhhhhhhhhhhhbsh
15-16 h: hhhhhhhhhhhhhhbsh
TXT);

        $this->assertSame(4, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day2::make();

        $this->assertSame(500, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day2::make()->setInput(<<<TXT
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
TXT);

        $this->assertSame(1, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day2::make();

        $this->assertSame(313, $day->solvePartTwo());
    }
}
