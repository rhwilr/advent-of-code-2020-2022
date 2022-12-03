<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2022;

use App\Solvers\AdventOfCode2022\Day3;
use Tests\TestCase;

class Day3Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day3::make()->setInput(<<<TXT
vJrwpWtwJgWrhcsFMMfFFhFp
jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL
PmmdzqPrVvPwwTWBwg
wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn
ttgJtRGJQctTZtZT
CrZsJsPPZsGzwwsLwLmpwMDw
TXT);

        $this->assertSame(157, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day3::make();

        $this->assertSame(7568, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day3::make()->setInput(<<<TXT
vJrwpWtwJgWrhcsFMMfFFhFp
jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL
PmmdzqPrVvPwwTWBwg
wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn
ttgJtRGJQctTZtZT
CrZsJsPPZsGzwwsLwLmpwMDw
TXT);

        $this->assertSame(70, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day3::make();

        $this->assertSame(2780, $day->solvePartTwo());
    }
}
