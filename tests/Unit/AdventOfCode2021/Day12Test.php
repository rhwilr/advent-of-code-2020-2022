<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2021;

use App\Solvers\AdventOfCode2021\Day12;
use Tests\TestCase;

class Day12Test extends TestCase
{
    public function testSolvePartOneExampleSmall(): void
    {
        $day = Day12::make()->setInput(<<<TXT
start-A
start-b
A-c
A-b
b-d
A-end
b-end
TXT
        );

        $this->assertSame(10, $day->solvePartOne());
    }

    public function testSolvePartOneExampleSlightlyLarger(): void
    {
        $day = Day12::make()->setInput(<<<TXT
dc-end
HN-start
start-kj
dc-start
dc-HN
LN-dc
HN-end
kj-sa
kj-HN
kj-dc
TXT
        );

        $this->assertSame(19, $day->solvePartOne());
    }

    public function testSolvePartOneExampleLarger(): void
    {
        $day = Day12::make()->setInput(<<<TXT
fs-end
he-DX
fs-he
start-DX
pj-DX
end-zg
zg-sl
zg-pj
pj-he
RW-he
fs-DX
pj-RW
zg-RW
start-pj
he-WI
zg-he
pj-fs
start-RW
TXT
        );

        $this->assertSame(226, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day12::make();

        $this->assertSame(3495, $day->solvePartOne());
    }

    public function testSolvePartTwoExampleSmall(): void
    {
        $day = Day12::make()->setInput(<<<TXT
start-A
start-b
A-c
A-b
b-d
A-end
b-end
TXT
        );

        $this->assertSame(36, $day->solvePartTwo());
    }

    public function testSolvePartTwoExampleSlightlyLarger(): void
    {
        $day = Day12::make()->setInput(<<<TXT
dc-end
HN-start
start-kj
dc-start
dc-HN
LN-dc
HN-end
kj-sa
kj-HN
kj-dc
TXT
        );

        $this->assertSame(103, $day->solvePartTwo());
    }

    public function testSolvePartTwoExampleLarger(): void
    {
        $day = Day12::make()->setInput(<<<TXT
fs-end
he-DX
fs-he
start-DX
pj-DX
end-zg
zg-sl
zg-pj
pj-he
RW-he
fs-DX
pj-RW
zg-RW
start-pj
he-WI
zg-he
pj-fs
start-RW
TXT
        );

        $this->assertSame(3509, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day12::make();

        $this->assertSame(94849, $day->solvePartTwo());
    }
}
