<?php

declare(strict_types=1);

namespace App\Solvers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

abstract class AbstractSolver
{
    private int $year;
    private int $day;

    private ?string $debugInput = null;
    private string $input;
    private Collection $parameters;

    public function __construct()
    {
        $this->setDateYear();
        $this->loadInput();

        $this->parameters = collect();
    }

    public static function make(): static
    {
        return new static;
    }

    public function setInput(string $debugInput): static
    {
        $this->debugInput = $debugInput;

        return $this;
    }

    public function setParameter(string $key, $value): static
    {
        $this->parameters->put($key, $value);

        return $this;
    }

    public function getInput(): string
    {
        return $this->debugInput ?? $this->input;
    }

    public function getParameter(string $key, $default)
    {
        return $this->parameters->get($key, $default);
    }

    public function solvePartOne()
    {
        return $this->partOne($this->getInput());
    }

    public function solvePartTwo()
    {
        return $this->partTwo($this->getInput());
    }

    abstract protected function partOne(string $input);

    abstract protected function partTwo(string $input);

    private function setDateYear()
    {
        $this->year = (int)Str::of(get_class($this))
            ->matchAll('/AdventOfCode(.*)\\\\Day.*/')->first();

        $this->day = (int)Str::of(get_class($this))
            ->matchAll('/AdventOfCode.*\\\\Day(.*)/')->first();
    }

    private function loadInput(): void
    {
        $path = resource_path(sprintf('%s/day%s/input.txt', $this->year, $this->day));

        if (!is_readable($path)) {
            throw new RuntimeException(sprintf('Input file not readable: %s', $path));
        }

        $this->input = file_get_contents($path);
    }
}
