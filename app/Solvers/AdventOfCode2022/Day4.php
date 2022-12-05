<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Stacks {
    private array $stacks;

    public function fillLevel(Collection $level)
    {
        foreach ($level as $stack => $container) {
            if (!isset($this->stacks[$stack + 1])) {
                $this->stacks[$stack + 1] = collect();
            }

            if ($container !== '') {
                $this->stacks[$stack + 1]->push($container);
            }
        }
    }

    public function move(int $from, int $to)
    {
        $container = $this->stacks[$from]->pop();

        $this->stacks[$to]->push($container);
    }

    public function moveMultiple(int $from, int $to, int $count = 1)
    {
        $containers = $this->stacks[$from]->pop($count);

        $reversed = collect($containers)->reverse();

        foreach ($reversed as $container) {
            $this->stacks[$to]->push($container);
        }
    }

    public function top(): string
    {
        $top = collect();

        foreach ($this->stacks as $stack) {
            $top->push($stack->pop());
        }

        return $top->join('');
    }

    public function dump()
    {
        dump($this->stacks);
    }
}

class Day4 extends AbstractSolver
{
    private Stacks $stacks;

    protected function parse(string $input)
    {
        [$stack, $moves] = Str::of($input)
            ->explode("\n\n");

        $this->stacks = $this->parseStacks($stack);

        return $this->parseMoves($moves);
    }

    protected function parseStacks(string $stacks)
    {
        $stack = new Stacks();

        $list = Str::of($stacks)
            ->explode("\n")
            ->map(function ($line) {
                return Str::of(chunk_split($line, 4, ','))
                ->explode(',')
                ->map(fn ($chunk) => str_replace('[', '', str_replace(']', '', trim($chunk))));
            })
            ->reverse()
            ->skip(1);

        foreach ($list as $level) {
            $stack->fillLevel($level);
        }

        return $stack;
    }

    protected function parseMoves(string $moves): Collection
    {
        return Str::of($moves)
            ->explode("\n")
            ->map(function ($move) {
                return Str::of($move)
                    ->matchAll('/\d+/')
                    ->map(fn ($item) => intval($item));
            })
            ->filter(function (Collection $move) {
                return $move->count() === 3;
            });
    }

    protected function partOne(string $input)
    {
        $moves = $this->parse($input);

        foreach ($moves as $move) {
            for ($i = 0; $i < $move[0]; $i++) {
                $this->stacks->move($move[1], $move[2]);
            }
        }

        return $this->stacks->top();
    }

    protected function partTwo(string $input)
    {
        $moves = $this->parse($input);

        foreach ($moves as $move) {
            $this->stacks->moveMultiple($move[1], $move[2], $move[0]);
        }

        return $this->stacks->top();
    }
}
