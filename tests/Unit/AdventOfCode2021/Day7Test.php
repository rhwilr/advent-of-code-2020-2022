<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day7;
use Tests\TestCase;

class Day7Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day7::make()->setInput(<<<TXT
16,1,2,0,4,2,7,1,2,14
TXT
        );

        $this->assertSame(37, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day7::make();

        $this->assertSame(329389, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day7::make()->setInput(<<<TXT
16,1,2,0,4,2,7,1,2,14
TXT
        );

        $this->assertSame(168, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day7::make();

        $this->assertSame(86397080, $day->solvePartTwo());
    }
}
