<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day3;
use Tests\TestCase;

class Day3Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day3::make()->setInput(<<<TXT
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
TXT
        );

        $this->assertSame(198, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day3::make();

        $this->assertSame(3895776, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day3::make()->setInput(<<<TXT
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
TXT
        );

        $this->assertSame(230, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day3::make();

        $this->assertSame(7928162, $day->solvePartTwo());
    }
}
