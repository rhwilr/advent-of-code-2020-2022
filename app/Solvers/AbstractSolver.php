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

    private ?string $loadExample = null;
    private ?string $debugInput = null;
    private Collection $parameters;

    public function __construct(string $loadExample = null)
    {
        $this->setDateYear();

        $this->parameters = collect();

        $this->loadExample = $loadExample;
    }

    public static function make(): static
    {
        return new static();
    }


    public static function makeExample(int $exampleNumber = null): static
    {
        if ($exampleNumber) {
            return new static(loadExample: "example$exampleNumber.txt");
        }

        return new static(loadExample: "example.txt");
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
        $inputFileName = $this->loadExample ?? 'input.txt';

        $path = resource_path(sprintf('%s/day%s/%s', $this->year, $this->day, $inputFileName));

        if (!is_readable($path)) {
            throw new RuntimeException(sprintf('Input file not readable: %s', $path));
        }

        return file_get_contents($path);
    }
}
