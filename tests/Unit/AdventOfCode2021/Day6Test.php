<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day6;
use Tests\TestCase;

class Day6Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day6::make()->setInput(<<<TXT
3,4,3,1,2
TXT
        );

        $this->assertSame(5934, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day6::make();

        $this->assertSame(388739, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day6::make()->setInput(<<<TXT
3,4,3,1,2
TXT
        );

        $this->assertSame(26984457539, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day6::make();

        $this->assertSame(1741362314973, $day->solvePartTwo());
    }
}
