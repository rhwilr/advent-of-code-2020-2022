<?php

namespace App\DataStructures\SevenSegment;

use Illuminate\Support\Collection;

class SevenSegment
{
    private array $knownNumbers = [];

    public function __construct()
    {
        foreach (range(0, 9) as $number) {
            $this->knownNumbers[$number] = collect();
        }
    }

    public function setCandidates(int $number, Collection $candidates)
    {
        $this->knownNumbers[$number] = $candidates->sort();
    }

    public function hasSegmentsFor(int $number): bool
    {
        return $this->knownNumbers[$number]->isNotEmpty();
    }

    public function allSegmentsFrom(int $number, Collection $candidates): bool
    {
        if (!$this->hasSegmentsFor($number)) {
            return false;
        }

        return $this->knownNumbers[$number]
            ->every(fn ($n) => $candidates->contains($n));
    }

    public function allSegmentsIn(int $number, Collection $candidates): bool
    {
        if (!$this->hasSegmentsFor($number)) {
            return false;
        }

        return $candidates
            ->every(fn ($n) => $this->knownNumbers[$number]->contains($n));
    }

    public function decode(Collection $candidates): int
    {
        return collect($this->knownNumbers)->filter(function (Collection $segments) use ($candidates) {
            return $segments->count() === $candidates->count() && $segments->diff($candidates)->isEmpty();
        })->keys()->firstOrFail();
    }
}
