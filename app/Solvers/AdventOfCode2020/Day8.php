<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\DataStructures\Graph\Algorithms\Reachability;
use App\DataStructures\Graph\Graph;
use App\DataStructures\Graph\Vertex;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class Day8 extends AbstractSolver
{
    const NOP = 'nop';
    const ACC = 'acc';
    const JMP = 'jmp';

    private $opCodes = [
        self::NOP,
        self::ACC,
        self::JMP,
    ];
    private \Illuminate\Support\Collection $instructions;
    private int $accumulator;
    private int $ip;

    public function __construct()
    {
        parent::__construct();

        $this->accumulator = 0;
        $this->ip = 0;
        $this->instructions = collect();
    }

    protected function partOne(string $input)
    {
        $this->parseInput($input);

        try {
            $this->run();
        } catch (\RuntimeException) {
            return $this->accumulator;
        }
    }

    protected function partTwo(string $input)
    {
        $this->parseInput($input);

        $instructions = $this->instructions->collect();

        foreach ($this->instructions as $key => [$instruction, $operand]) {
            if ($instruction == self::NOP) {
                $this->instructions->put($key, [self::JMP, $operand]);
            } elseif ($instruction == self::JMP) {
                $this->instructions->put($key, [self::NOP, $operand]);
            }

            try {
                return $this->run();
            } catch (\RuntimeException) {
                $this->resetVM();
                $this->instructions = $instructions->collect();
            }
        }
    }

    protected function parseInput(string $input): void
    {
        $this->instructions = Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => $this->parseLine($line));
    }

    private function parseLine(string $line)
    {
        $pattern = '/(\w+) (.\d+)/';

        $matches = Regex::match($pattern, $line);
        throw_unless($matches->hasMatch(), 'Could not parse line: '. $line);

        return [$matches->group(1) , intval($matches->group(2))];
    }

    /**
     * @return int
     */
    protected function run(): int
    {
        while (true) {
            // Return the accumulator if the program exits
            if (!$this->instructions->has($this->ip)) {
                return $this->accumulator;
            }

            [$instruction, $operand] = $this->instructions->get($this->ip);

            // delete the instruction to prevent loops
            $this->instructions->put($this->ip, null);

            switch ($instruction) {
                case self::NOP:
                    $this->ip++;
                    break;
                case self::ACC:
                    $this->accumulator += $operand;
                    $this->ip++;
                    break;
                case self::JMP:
                    $this->ip += $operand;
                    break;
                default:
                    throw new \RuntimeException('Loop detected');
            }
        }
    }

    private function resetVM()
    {
        $this->accumulator = 0;
        $this->ip = 0;
    }
}
