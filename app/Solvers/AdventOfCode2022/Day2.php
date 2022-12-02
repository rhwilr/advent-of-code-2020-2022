<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpParser\Builder\Class_;
use RuntimeException;

enum Symbols: int {
    case Rock = 1;
    case Paper = 2;
    case Scissors = 3;
}

enum State: int {
    case Win = 6;
    case Draw = 3;
    case Loos = 0;
}

class Game {
    public function __construct(
        public Symbols $opponent,
        public ?Symbols $me = null,
        public ?State $desiredState = null,
    ) {}
}

class Day2 extends AbstractSolver
{
    private const SHAPE_OPPONENT = [
        'A' => Symbols::Rock,
        'B' => Symbols::Paper,
        'C' => Symbols::Scissors,
    ];

    private const SHAPE_ME = [
        'X' => Symbols::Rock,
        'Y' => Symbols::Paper,
        'Z' => Symbols::Scissors,
    ];

    private const END_ME = [
        'X' => State::Loos,
        'Y' => State::Draw,
        'Z' => State::Win,
    ];

    protected function parse(string $input): Collection
    {
        return Str::of(trim($input))
            ->explode("\n");
    }

    protected function partOne(string $input)
    {
        return $this->parse($input)
            ->map(function ($game) {
                [$opponent, $me] =  Str::of($game)
                    ->explode(' ');

                return new Game(
                    opponent: self::SHAPE_OPPONENT[$opponent],
                    me: self::SHAPE_ME[$me],
                );
            })
            ->map(function (Game $game) {
                $state = $this->playGame($game);

                return $game->me->value + $state->value;
            })
            ->sum();
    }

    protected function partTwo(string $input)
    {
        return $this->parse($input)
            ->map(function ($game) {
                [$opponent, $state] =  Str::of($game)
                    ->explode(' ');

                return new Game(
                    opponent:  self::SHAPE_OPPONENT[$opponent],
                    desiredState: self::END_ME[$state],
                );
            })
            ->map(function (Game $game) {
                $symbol = $this->playReverseGame($game);

                return $game->desiredState->value + $symbol->value;
            })
            ->sum();
    }

    private function playGame(Game $game): State
    {
        if ($game->me->value === $game->opponent->value) {
            return State::Draw;
        }

        if ($this->gameRules()[$game->me->value] === $game->opponent->value) {
            return State::Win;
        }

        return State::Loos;
    }

    private function playReverseGame(Game $game): Symbols
    {
        if ($game->desiredState == State::Draw) {
            return $game->opponent;
        }

        if ($game->desiredState == State::Loos) {
            return Symbols::from($this->gameRules()[$game->opponent->value]);
        }

        $loosingMatch = array_flip($this->gameRules());

        return Symbols::from($loosingMatch[$game->opponent->value]);

    }

    private function gameRules(): array
    {
        return [
            Symbols::Rock->value => Symbols::Scissors->value,
            Symbols::Paper->value => Symbols::Rock->value,
            Symbols::Scissors->value => Symbols::Paper->value,
        ];
    }
}
