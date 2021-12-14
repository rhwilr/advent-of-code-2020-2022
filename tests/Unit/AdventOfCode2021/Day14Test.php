<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day14;
use Tests\TestCase;

class Day14Test extends TestCase
{
    public function testSolvePartOneExample(): void
    {
        $day = Day14::make()->setInput(<<<TXT
NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C
TXT
        );

        $this->assertSame(1588, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day14::make();

        $this->assertSame(2509, $day->solvePartOne());
    }

    public function testSolvePartTwoExample(): void
    {
        $day = Day14::make()->setInput(<<<TXT
NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C
TXT
        );

        $this->assertSame(2188189693529, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day14::make();

        $this->assertSame(2827627697643, $day->solvePartTwo());
    }
}
