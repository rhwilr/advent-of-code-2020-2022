<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day1;
use Tests\TestCase;

class Day1Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day1::make()->setInput(<<<TXT
1721
979
366
299
675
1456
TXT);

        $this->assertSame('514579', $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day1::make();

        $this->assertSame('987339', $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day1::make()->setInput(<<<TXT
1721
979
366
299
675
1456
TXT);

        $this->assertSame('241861950', $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day1::make();

        $this->assertSame('259521570', $day->solvePartTwo());
    }
}
