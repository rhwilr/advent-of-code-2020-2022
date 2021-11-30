<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day5;
use Tests\TestCase;

class Day5Test extends TestCase
{
    public function testCalculatingSeatID(): void
    {
        $this->assertSame(567, Day5::make()->calculateSeatId('BFFFBBFRRR'));
        $this->assertSame(119, Day5::make()->calculateSeatId('FFFBBBFRRR'));
        $this->assertSame(820, Day5::make()->calculateSeatId('BBFFBBFRLL'));
    }

    public function testSolvePartOne(): void
    {
        $day = Day5::make();

        $this->assertSame(861, $day->solvePartOne());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day5::make();

        $this->assertSame(633, $day->solvePartTwo());
    }
}
