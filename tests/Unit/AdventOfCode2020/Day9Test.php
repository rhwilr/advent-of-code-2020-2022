<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day9;
use Tests\TestCase;

class Day9Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day9::make()->setInput(<<<TXT
35
20
15
25
47
40
62
55
65
95
102
117
150
182
127
219
299
277
309
576
TXT);

        $day->setParameter('length', 5);

        $this->assertSame(127, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day9::make();

        $this->assertSame(507622668, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day9::make()->setInput(<<<TXT
35
20
15
25
47
40
62
55
65
95
102
117
150
182
127
219
299
277
309
576
TXT
        );

        $day->setParameter('length', 5);

        $this->assertSame(62, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day9::make();

        $this->assertSame(76688505, $day->solvePartTwo());
    }
}
