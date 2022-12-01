<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day1;
use Tests\TestCase;

class Day1Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day1::make()->setInput(<<<TXT
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
TXT);

        $this->assertSame(24000, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day1::make();

        $this->assertSame(67016, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day1::make()->setInput(<<<TXT
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
TXT);

        $this->assertSame(45000, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day1::make();

        $this->assertSame(200116, $day->solvePartTwo());
    }
}
