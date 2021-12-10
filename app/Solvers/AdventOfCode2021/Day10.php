<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\DataStructures\SevenSegment\SevenSegment;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day10 extends AbstractSolver
{
    private const MAP = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];

    protected function partOne(string $input)
    {
        $input = $this->parseInput($input);

        return $this->scoreSyntaxErrors($input);
    }

    protected function partTwo(string $input)
    {
        $input = $this->parseInput($input);

        $scores = $this->repairIncompleteLines($input);

        return $scores->get($scores->count() / 2);
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->split(1)
            );
    }

    private function scoreSyntaxErrors(Collection $input)
    {
        $score = 0;
        foreach ($input as $line) {
            $syntaxError = $this->findSyntaxErrorInLine($line);

            if ($syntaxError['error']) {
                $score += $this->getErrorScoreFor($syntaxError['found']);
            }
        }

        return $score;
    }

    private function findSyntaxErrorInLine(Collection $line): array
    {
        $stack = collect();
        $map = collect(self::MAP);

        foreach ($line as $char) {
            if ($map->has($char)) {
                $stack->push($char);
            }

            if ($map->contains($char)) {
                $stackMustBe = $map->flip()->get($char);
                $topOfStack = $stack->pop();

                if ($stackMustBe !== $topOfStack) {
                    return [
                        'error' => true,
                        'expected' => $topOfStack,
                        'found' => $char,
                        'stack' => $stack
                    ];
                }
            }
        }

        return [
            'error' => false,
            'stack' => $stack
        ];
    }

    private function getErrorScoreFor(string $errorChar)
    {
        if ($errorChar === ')') {
            return 3;
        }
        if ($errorChar === ']') {
            return 57;
        }
        if ($errorChar === '}') {
            return 1197;
        }
        if ($errorChar === '>') {
            return 25137;
        }
    }

    private function getRepairScoreFor(string $errorChar)
    {
        if ($errorChar === ')') {
            return 1;
        }
        if ($errorChar === ']') {
            return 2;
        }
        if ($errorChar === '}') {
            return 3;
        }
        if ($errorChar === '>') {
            return 4;
        }
    }

    private function repairIncompleteLines(Collection $input): Collection
    {
        $scores = collect();
        $map = collect(self::MAP);

        foreach ($input as $line) {
            $syntaxError = $this->findSyntaxErrorInLine($line);

            if (!$syntaxError['error']) {
                $score = $syntaxError['stack']
                    ->reverse()
                    ->map(fn ($char) => $map->get($char))
                    ->map(fn ($char) => $this->getRepairScoreFor($char))
                    ->reduce(fn ($carry, $score) => $carry * 5 + $score, 0);

                $scores->push($score);
            }
        }

        return $scores->sort()->values();
    }
}
