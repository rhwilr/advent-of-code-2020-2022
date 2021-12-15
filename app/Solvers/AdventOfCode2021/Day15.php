<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\DataStructures\Grid\Grid;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day15 extends AbstractSolver
{
    private Grid $grid;
    private Grid $distances;

    private Collection $unvisited;

    private ?string $cursor;
    private string $last;

    protected function partOne(string $input)
    {
        $this->parseInput($input);
        $this->init();

        $this->dijkstra();

        [$x, $y] = Str::of($this->last)->explode(',')
            ->map(fn ($n) => intval($n));

        return $this->distances->get($x, $y);
    }

    protected function partTwo(string $input)
    {
    }

    protected function parseInput(string $input)
    {
        $grid = Str::of($input)
            ->explode("\n")
            ->map(fn ($line) => Str::of($line)
                ->split(1)
                ->map(fn ($n) => intval($n))
            );

        $this->grid = Grid::of($grid);

        return $this;
    }

    private function init()
    {
        $this->distances = Grid::init(PHP_INT_MAX, $this->grid->getSizeX(), $this->grid->getSizeY());
        $this->distances->set(0, 0, 0);

        $this->unvisited = collect();

        for($i = 0; $i < $this->grid->getSizeX(); $i++) {
            for ($j = 0; $j < $this->grid->getSizeY(); $j++) {
                $this->unvisited->put("$i,$j", PHP_INT_MAX);
            }
        }
        $this->unvisited->put('0,0', 0);

        $this->cursor = '0,0';
        $this->last = $this->grid->getSizeX() - 1 . ',' . $this->grid->getSizeY() - 1;
    }

    private function dijkstra()
    {
        while ($this->unvisited->has($this->last) && $this->cursor !== null) {

            [$x, $y] = Str::of($this->cursor)->explode(',')
                ->map(fn ($n) => intval($n));

            $this->handleNode($x, $y);

            $this->cursor = $this->getNextCursor();
        }
    }

    private function handleNode(int $x, int $y)
    {
        $neighbours = $this->grid->neighbours($x, $y)
            ->filter(fn ($next, $key) => $this->unvisited->has($key))
            ->keys();


        foreach ($neighbours as $key) {
            [$x2, $y2] = Str::of($key)->explode(',')
                ->map(fn ($n) => intval($n));

            $distance = min(
                $this->distances->get($x2, $y2),
                $this->distances->get($x, $y) + $this->grid->get($x2, $y2)
            );

            $this->distances->set($x2, $y2, $distance);
            $this->unvisited->put("$x2,$y2", $distance);
        }


        $this->unvisited->forget("$x,$y");
    }

    private function getNextCursor()
    {
        if ($this->unvisited->isEmpty()) {
            return null;
        }

        $min = $this->unvisited->min();

        return $this->unvisited->search($min);
    }
}
