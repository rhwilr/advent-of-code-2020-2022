<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

class Day4 extends AbstractSolver
{
    private const BOARD_SIZE = 5;

    protected function partOne(string $input)
    {
        [$sequence, $boards] = $this->parseInput($input);

        foreach ($sequence as $number) {
            [$valid, $key] = $this->playRound($number, $boards);

            if ($valid) {
                return $valid->filter()->sum() * $number;
            }
        }

        throw new \Exception('No board wins');
    }

    protected function partTwo(string $input)
    {
        [$sequence, $boards] = $this->parseInput($input);

        foreach ($sequence as $number) {
            [, , $valid] = $this->playRound($number, $boards, false);

            $valid->each(fn ($item) => $boards->forget($item[1]));

            if ($boards->count() === 0) {
                return $valid[0][0]->filter()->sum() * $number;
            }
        }

        throw new \Exception('No board wins');
    }

    protected function parseInput(string $input)
    {
        $tmp = Str::of($input)
            ->explode("\n")
            ->filter();

        $sequence = Str::of($tmp->first())
            ->explode(',')
            ->map(fn ($n) => intval($n));

        $boards = $tmp->skip(1)
            ->flatMap(fn ($line) => Str::of($line)
                ->split('/\s+/')
                ->filter(fn ($n) => $n !== '')
                ->map(fn ($n) => intval($n))
            )
            ->chunk(self::BOARD_SIZE * self::BOARD_SIZE)
            ->map(fn ($board) => $board->values());

        return [$sequence, $boards];
    }

    private function playRound(int $number, Collection &$boards, $returnOnFind = true): array
    {
        $valid = collect();

        foreach ($boards as $key => $board) {
            $board = $board->map(fn ($n) =>
                $n === $number ? null: $n
            );

            $boards->put($key, $board);

            $validBoard = $this->validateBoard($board);

            if ($validBoard) {
                $valid->push([$validBoard, $key]);
            }

            if ($validBoard && $returnOnFind) {
                return [$validBoard, $key, $valid];
            }
        }

        return [null, null, $valid];
    }

    private function validateBoard($board): ?Collection
    {
        foreach (range(0, self::BOARD_SIZE-1) as $i) {
            // Validate row
            if ($board->chunk(self::BOARD_SIZE)
                ->contains(fn ($chunk) => $chunk->every(fn ($i) => is_null($i)))) {
                return $board;
            }

            // Validate column
            if ($board->filter(fn ($v, $key) => $key % self::BOARD_SIZE === $i)
                ->every(fn ($i) => is_null($i))) {
                return $board;
            }
        }

        return null;
    }

}
