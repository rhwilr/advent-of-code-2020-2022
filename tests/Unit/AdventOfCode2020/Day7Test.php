<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day8;
use Tests\TestCase;

class Day7Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day8::make()->setInput(<<<TXT
light red bags contain 1 bright white bag, 2 muted yellow bags.
dark orange bags contain 3 bright white bags, 4 muted yellow bags.
bright white bags contain 1 shiny gold bag.
muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.
shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.
vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.
faded blue bags contain no other bags.
dotted black bags contain no other bags.
TXT);

        $this->assertSame(4, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day8::make();

        $this->assertSame(302, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day8::make()->setInput(<<<TXT
shiny gold bags contain 2 dark red bags.
dark red bags contain 2 dark orange bags.
dark orange bags contain 2 dark yellow bags.
dark yellow bags contain 2 dark green bags.
dark green bags contain 2 dark blue bags.
dark blue bags contain 2 dark violet bags.
dark violet bags contain no other bags.
TXT
        );

        $this->assertSame(126, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day8::make();

        $this->assertSame(4165, $day->solvePartTwo());
    }
}
