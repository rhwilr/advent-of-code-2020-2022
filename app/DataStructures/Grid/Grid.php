<?php

namespace App\DataStructures\Grid;

use Illuminate\Support\Collection;

class Grid
{
    private array $grid;

    private int $sizeX;
    private int $sizeY;

    /**
     * @param Collection<int, Collection> $input
     * @return Grid
     */
    public static function of(Collection $input): self
    {
        return (new Grid())->from($input);
    }

    /**
     * @param mixed $init
     * @return Grid
     */
    public static function init(mixed $init, int $countX, int $countY)
    {
        return (new Grid())->fill($init, $countX, $countY);
    }

    /**
     * @param Collection<int, Collection> $input
     * @return self
     */
    public function from(Collection $input): self
    {
        $this->sizeX = $input->first()->count();
        $this->sizeY = $input->count();

        $this->grid = $input->map(fn (Collection $row) => $row->toArray())
            ->toArray();

        return $this;
    }

    /**
     * @param mixed $init
     * @param int $countX
     * @param int $countY
     * @return Grid
     */
    private function fill(mixed $init, int $countX, int $countY)
    {
        $this->sizeX = $countX;
        $this->sizeY = $countY;

        $this->grid = collect(array_fill(0, $this->sizeY, null))
            ->map(fn ($row) => array_fill(0, $this->sizeX, $init))
            ->toArray();

        return $this;
    }

    /**
     * @return int
     */
    public function getSizeX(): int
    {
        return $this->sizeX;
    }

    /**
     * @return int
     */
    public function getSizeY(): int
    {
        return $this->sizeY;
    }

    public function get(int $x, int $y)
    {
        if ($y < 0 || $x < 0) {
            return null;
        }

        if ($y > $this->sizeY - 1 || $x > $this->sizeX  - 1) {
            return null;
        }

        $row = $this->grid[$y] ?? null;

        if (is_null($row)) {
            return null;
        }

        return $row[$x] ?? null;
    }

    public function set(int $x, int $y, int $value)
    {
        $this->grid[$y][$x] = $value;
    }

    public function clone(): static
    {
        return $this->from($this->grid);
    }

    public function neighbours(int $x, int $y): Collection
    {
        return collect([
            $x-1 . ',' . $y => $this->get($x - 1, $y),
            $x+1 . ',' . $y => $this->get($x + 1, $y),
            $x . ',' . $y-1 => $this->get($x, $y - 1),
            $x . ',' . $y+1 => $this->get($x, $y + 1),
        ])
            ->filter(fn ($n) => !is_null($n));
    }
}
