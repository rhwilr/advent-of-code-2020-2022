<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2021;

use App\DataStructures\Graph\Graph;
use App\DataStructures\Graph\Vertex;
use App\Solvers\AbstractSolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day12 extends AbstractSolver
{
    private Graph $graph;
    private Vertex $start;
    private Vertex $end;

    public function __construct()
    {
        parent::__construct();

        $this->graph = new Graph();
    }

    protected function partOne(string $input)
    {
        $input = $this->parseInput($input);

        $this->createGraph($input);

        $this->start = $this->graph->vertices->get('start');
        $this->end = $this->graph->vertices->get('end');

        return $this->countPaths($this->start, null, []);
    }

    protected function partTwo(string $input)
    {
        $input = $this->parseInput($input);

        $this->createGraph($input);

        $this->start = $this->graph->vertices->get('start');
        $this->end = $this->graph->vertices->get('end');

        return $this->countPathsPartTwo($this->start, null, []);
    }

    protected function parseInput(string $input): Collection
    {
        return Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn ($line) => Str::of($line)
                ->explode('-')
            );
    }

    private function createGraph(Collection $input)
    {
        foreach ($input as $item) {
            $start = $item[0];
            $end = $item[1];

            $startVertex = $this->getOrCreateVertex($start);
            $endVertex = $this->getOrCreateVertex($end);

            $startVertex->createUndirectedEdgeTo($endVertex);
        }
    }

    /**
     * @param string $name
     */
    private function getOrCreateVertex(string $name): Vertex
    {
        if ($this->graph->vertices->has($name)) {
            return $this->graph->vertices->get($name);
        }

        return $this->graph->createVertex($name);
    }

    private function countPaths(Vertex $currentNode, ?Vertex $previous, $smallVisited): int
    {
        $counter = 0;

        if ($currentNode === $this->end) {
            return 1;
        }

        if (ctype_lower($currentNode->getId())) {
            $smallVisited[$currentNode->getId()] = true;
        }

        foreach ($currentNode->getEdgesOut() as $edge) {
            $neighbour = $edge->vertexFrom($currentNode);

            if (!ctype_lower($currentNode->getId()) && $neighbour === $previous) {
                continue;
            }

            if (array_key_exists($neighbour->getId(), $smallVisited)) {
                continue;
            }

            $counter += $this->countPaths($neighbour, $currentNode, $smallVisited);
        }

        return $counter;
    }

    private function countPathsPartTwo(Vertex $currentNode, ?Vertex $previous, $smallVisited): int
    {
        $counter = 0;

        if ($currentNode === $this->end) {
            return 1;
        }

        if (ctype_lower($currentNode->getId()) && $currentNode !== $this->start) {
            $smallVisited[$currentNode->getId()] = ($smallVisited[$currentNode->getId()] ?? 0) + 1;
        }

        foreach ($currentNode->getEdgesOut() as $edge) {
            $neighbour = $edge->vertexFrom($currentNode);


            if (ctype_upper($currentNode->getId()) && ctype_upper($neighbour->getId()) && $neighbour === $previous) {
                continue;
            }

            if ($neighbour === $this->start) {
                continue;
            }

            if (($smallVisited[$neighbour->getId()] ?? 0) >= 1 && max(array_values($smallVisited)) > 1) {
                continue;
            }

            $counter += $this->countPathsPartTwo($neighbour, $currentNode, $smallVisited);
        }

        return $counter;
    }
}
