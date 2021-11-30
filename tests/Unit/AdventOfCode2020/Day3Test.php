<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day3;
use Tests\TestCase;

class Day3Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day3::make()->setInput(<<<TXT
..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#
TXT);

        $this->assertSame(7, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day3::make();

        $this->assertSame(270, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day3::make()->setInput(<<<TXT
..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#
TXT);

        $this->assertSame(336, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day3::make();

        $this->assertSame(2122848000, $day->solvePartTwo());
    }
}
