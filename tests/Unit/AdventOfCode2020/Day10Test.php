<?php

declare(strict_types=1);

namespace Tests\Unit\AdventOfCode2020;

use App\Solvers\AdventOfCode2020\Day10;
use Tests\TestCase;

class Day10Test extends TestCase
{
    public function testSolvePartOneExample1(): void
    {
        $day = Day10::make()->setInput(<<<TXT
16
10
15
5
1
11
7
19
6
12
4
TXT);

        $this->assertSame(35, $day->solvePartOne());
    }

    public function testSolvePartOneExample2(): void
    {
        $day = Day10::make()->setInput(<<<TXT
28
33
18
42
31
14
46
20
48
47
24
23
49
45
19
38
39
11
1
32
25
35
8
17
7
9
4
2
34
10
3
TXT);

        $this->assertSame(220, $day->solvePartOne());
    }

    public function testSolvePartOne(): void
    {
        $day = Day10::make();

        $this->assertSame(2812, $day->solvePartOne());
    }

    public function testSolvePartTwoExample1(): void
    {
        $day = Day10::make()->setInput(<<<TXT
16
10
15
5
1
11
7
19
6
12
4
TXT);

        $this->assertSame(8, $day->solvePartTwo());
    }

    public function testSolvePartTwoExample2(): void
    {
        $day = Day10::make()->setInput(<<<TXT
28
33
18
42
31
14
46
20
48
47
24
23
49
45
19
38
39
11
1
32
25
35
8
17
7
9
4
2
34
10
3
TXT);

        $this->assertSame(19208, $day->solvePartTwo());
    }

    public function testSolvePartTwo(): void
    {
        $day = Day10::make();

        $this->assertSame(386869246296064, $day->solvePartTwo());
    }
}
