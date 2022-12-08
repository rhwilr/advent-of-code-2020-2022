<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2022;

use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class File
{
    public function __construct(
        public string $name,
        public int $size,
        public Folder $parent
    ) {}
}

class Folder
{
    public function __construct(
        public string $name,
        public ?Folder $parent = null
    ) {
        $this->children = collect();
    }

    public Collection $children;
    public int $size;
}

class Day7 extends AbstractSolver
{
    const DISK = 70000000;
    const UPDATE = 30000000;

    private ?Folder $root = null;
    private ?Folder $currentFolder = null;

    protected function parse(string $input)
    {
        return Str::of($input)
            ->explode("\n")
            ->each(fn ($line) => $this->parseLine($line));
    }

    protected function partOne(string $input)
    {
        $this->parse($input);
        $this->calculateSize($this->root);

        return $this->sumFoldersBelow100K($this->root);
    }

    protected function partTwo(string $input)
    {
        $this->parse($input);
        $this->calculateSize($this->root);

        $unused = self::DISK - $this->root->size;
        $required = self::UPDATE - $unused;

        $folders = $this->getFoldersLargerThan($this->root, $required);

        return $folders->map(fn (Folder $folder) => $folder->size)
            ->sort()
            ->first();
    }

    private function parseLine(string $line)
    {
        // Parse first init line
        if (!$this->root) {
            throw_unless($line === '$ cd /', 'First line must be root');

            $this->root = new Folder('/');

            $this->currentFolder = $this->root;

            return;
        }

        if (Str::startsWith($line, '$ ')) {
            return $this->parseCommand($line);
        }

        return $this->parseListing($line);
    }

    private function parseCommand(string $line)
    {
        // Listing directory, just return
        if ($line === '$ ls') {
            return;
        }

        if (Str::startsWith($line, '$ cd')) {
            $name = Str::after($line, '$ cd ');

            // Go to parent
            if ($name === '..') {
                $this->currentFolder = $this->currentFolder->parent;
                return;
            }

            // Find matching child
            foreach ($this->currentFolder->children as $child) {
                if ($child instanceof Folder && $child->name === $name) {
                    $this->currentFolder = $child;
                    return;
                }
            }

            // Error
            abort(500);
        }

    }

    private function parseListing(string $line)
    {
        // Folder
        if (Str::startsWith($line, 'dir')) {
            $name = Str::after($line, 'dir ');
            $folder = new Folder($name, $this->currentFolder);

            return $this->currentFolder->children->push($folder);
        }

        if (Str::contains($line, ' ')) {
            // File
            [$size, $name] = Str::of($line)->explode(' ');
            $file = new File($name, intval($size), $this->currentFolder);

            return $this->currentFolder->children->push($file);
        }
    }

    private function calculateSize(Folder $currentFolder): int
    {
        $size = 0;

        foreach ($currentFolder->children as $child) {
            if ($child instanceof File) {
                $size += $child->size;
            } else {
                $size += $this->calculateSize($child);
            }
        }

        $currentFolder->size = $size;

        return $size;
    }

    private function sumFoldersBelow100K(Folder $currentFolder)
    {
        $sum = 0;

        foreach ($currentFolder->children as $child) {
            if ($child instanceof Folder) {
                if ($child->size <= 100000) {
                    $sum += $child->size;
                }
                $sum += $this->sumFoldersBelow100K($child);
            }
        }

        return $sum;
    }

    private function getFoldersLargerThan(Folder $currentFolder, int $required): Collection
    {
        $folder = collect();

        foreach ($currentFolder->children as $child) {
            if ($child instanceof Folder) {
                if ($child->size >= $required) {
                    $folder->push($child);
                }

                $folder->push(...$this->getFoldersLargerThan($child, $required));
            }
        }

        return $folder;
    }
}
