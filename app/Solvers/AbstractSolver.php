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

    private bool $loadExample = false;
    private ?string $debugInput = null;
    private Collection $parameters;

    public function __construct($loadExample = false)
    {
        $this->setDateYear();

        $this->parameters = collect();

        $this->loadExample = $loadExample;
    }

    public static function make(): static
    {
        return new static();
    }


    public static function makeExample(): static
    {
        return new static(loadExample: true);
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
        return $this->debugInput ?? $this->loadInput();
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

    private function loadInput(): string
    {
        $inputFileName = $this->loadExample ? 'example.txt' : 'input.txt';

        $path = resource_path(sprintf('%s/day%s/%s', $this->year, $this->day, $inputFileName));

        if (!is_readable($path)) {
            throw new RuntimeException(sprintf('Input file not readable: %s', $path));
        }

        return file_get_contents($path);
    }
}
