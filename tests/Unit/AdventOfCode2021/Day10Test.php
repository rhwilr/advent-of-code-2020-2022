<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day10;
use Tests\TestCase;

class Day10Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day10::make()->setInput(<<<TXT
[({(<(())[]>[[{[]{<()<>>
[(()[<>])]({[<{<<[]>>(
{([(<{}[<>[]}>{[]{[(<()>
(((({<>}<{<{<>}{[]{[]{}
[[<[([]))<([[{}[[()]]]
[{[{({}]{}}([{[{{{}}([]
{<[[]]>}<{[{[{[]{()[[[]
[<(<(<(<{}))><([]([]()
<{([([[(<>()){}]>(<<{{
<{([{{}}[<[[[<>{}]]]>[]]
TXT
        );

        $this->assertSame(26397, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day10::make();

        $this->assertSame(341823, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day10::make()->setInput(<<<TXT
[({(<(())[]>[[{[]{<()<>>
[(()[<>])]({[<{<<[]>>(
{([(<{}[<>[]}>{[]{[(<()>
(((({<>}<{<{<>}{[]{[]{}
[[<[([]))<([[{}[[()]]]
[{[{({}]{}}([{[{{{}}([]
{<[[]]>}<{[{[{[]{()[[[]
[<(<(<(<{}))><([]([]()
<{([([[(<>()){}]>(<<{{
<{([{{}}[<[[[<>{}]]]>[]]
TXT
        );

        $this->assertSame(288957, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day10::make();

        $this->assertSame(2801302861, $day->solvePartTwo());
    }
}
