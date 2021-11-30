<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\DataStructures\Graph\Algorithms\Reachability;
use App\DataStructures\Graph\Graph;
use App\DataStructures\Graph\Vertex;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class Day11 extends AbstractSolver
{
    private Collection $layout;
    private Collection $layoutNextIteration;
    private string $cachePrefix;

    private int $occupiedLimit = 4;

    protected function partOne(string $input)
    {
        $this->cachePrefix = 'partOne';

        $this->layout = collect();
        $this->parseInput($input);

        $iterations = 0;
        while ($this->simulate()) {
            $iterations++;
        }

        return $this->layout->flatten()
            ->filter(fn ($item) => $item === '#')
            ->count();
    }

    protected function partTwo(string $input)
    {
        $this->cachePrefix = 'partTwo';
        $this->occupiedLimit = 5;

        $this->layout = collect();
        $this->parseInput($input);

        $iterations = 0;
        while ($this->simulate(true)) {
            $iterations++;
        }

        return $this->layout->flatten()
            ->filter(fn ($item) => $item === '#')
            ->count();
    }

    private function parseInput(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->values()
            ->each(fn($line, $y) => $this->parseLine($line, $y));
    }

    private function parseLine(string $line, int $y)
    {
        $this->layout[$y] = collect();

        Str::of($line)
            ->split('//')
            ->filter()
            ->values()
            ->each(function($seat, $x) use ($y) {
                $this->layout[$y][$x] = $seat;
            });
    }

    private function simulate(bool $useRayTracing = false): bool
    {
        $modified = false;
        $this->layoutNextIteration = $this->layout->map(fn ($line) => $line->collect());

        foreach ($this->layout as $y => $row) {
            foreach ($row as $x => $seat) {
                $modified = $this->simulateSeat($y, $x, $seat, $useRayTracing) || $modified;
            }
        }

        $this->layout = $this->layoutNextIteration;

        return $modified;
    }

    private function simulateSeat(int $y, int $x, string $seat, bool $useRayTracing = false): bool
    {
        if ($seat === '.') {
            $this->layoutNextIteration[$y][$x] = '.';
            return false;
        }

        $adjacentSeats = $this->getSeatsToCheck($y, $x, $useRayTracing)
            ->map(function ($item) {
                [$y, $x] = $item;
                return $this->layout->get($y)?->get($x);
            });

        if ($seat === 'L') {
            if ($adjacentSeats->contains('#')) {
                $this->layoutNextIteration[$y][$x] = 'L';
                return false;
            }

            $this->layoutNextIteration[$y][$x] = '#';
            return true;
        }

        if ($seat === '#') {
            $count = $adjacentSeats->filter(fn ($item) => $item === '#')
                ->count();

            if ($count >= $this->occupiedLimit) {
                $this->layoutNextIteration[$y][$x] = 'L';
                return true;
            }

            $this->layoutNextIteration[$y][$x] = '#';
            return false;
        }

        throw new \Exception("Simulation error: [$y][$x] -> $seat");
    }

    private function printLayout()
    {
        $out = "";
        foreach ($this->layout as $y => $row) {
            foreach ($row as $x => $seat) {
                $out .= $seat;
            }
            $out .= "\n";
        }

        dump($out);
    }

    private function getSeatsToCheck(int $y, int $x, bool $useRayTracing): Collection
    {
        if (Config::has('day11-'. $this->cachePrefix. "$y:$x")) {
            return Config::get('day11-'. $this->cachePrefix. "$y:$x");
        }

        if ($useRayTracing) {
            return $this->getSeatsToCheckUsingRayTracing($y, $x);
        }

        return $this->getSeatsToCheckDirect($y, $x);
    }

    public function getSeatsToCheckUsingRayTracing(int $y, int $x): Collection
    {
        $this->traceToSeat($y, $x, -1, -1);

        $seats = collect([
            $this->traceToSeat($y, $x, -1, -1),
            $this->traceToSeat($y, $x, -1,  0),
            $this->traceToSeat($y, $x, -1, +1),
            $this->traceToSeat($y, $x,  0, -1),
            $this->traceToSeat($y, $x,  0, +1),
            $this->traceToSeat($y, $x, +1, -1),
            $this->traceToSeat($y, $x, +1,  0),
            $this->traceToSeat($y, $x, +1, +1),
        ])
            ->filter();

        Config::set('day11-'. $this->cachePrefix. "$y:$x", $seats);

        return $seats;
    }

    private function getSeatsToCheckDirect(int $y, int $x): Collection
    {
        $seats = collect([
            [($y -1), ($x -1)],
            [($y -1), ($x)],
            [($y -1), ($x +1)],
            [($y),  ($x -1)],
            [($y),  ($x +1)],
            [($y +1), ($x -1)],
            [($y +1), ($x)],
            [($y +1), ($x +1)],
        ])
            ->filter(function ($item) {
                [$y, $x] = $item;

                $seat = $this->layout->get($y)?->get($x);

                return !is_null($seat) && $seat !== '.';
            });

        Config::set('day11-'. $this->cachePrefix. "$y:$x", $seats);

        return $seats;
    }

    private function traceToSeat(int $y, int $x, int $moveY, int $moveX)
    {
        $currentY = $y + $moveY;
        $currentX = $x + $moveX;

        while (true) {
            $seat = $this->layout->get($currentY)?->get($currentX);

            if (is_null($seat)) {
                return null;
            }

            if ($seat !== '.') {
                return [$currentY, $currentX];
            }

            $currentY += $moveY;
            $currentX += $moveX;
        }
    }
}
