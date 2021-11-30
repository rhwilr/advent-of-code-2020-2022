<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day8;
use Tests\TestCase;

class Day8Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day8::make()->setInput(<<<TXT
nop +0
acc +1
jmp +4
acc +3
jmp -3
acc -99
acc +1
jmp -4
acc +6
TXT
        );

        $this->assertSame(5, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day8::make();

        $this->assertSame(1867, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day8::make()->setInput(<<<TXT
nop +0
acc +1
jmp +4
acc +3
jmp -3
acc -99
acc +1
jmp -4
acc +6
TXT
        );

        $this->assertSame(8, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day8::make();

        $this->assertSame(1303, $day->solvePartTwo());
    }
}
