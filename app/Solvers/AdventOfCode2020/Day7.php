<?php

declare(strict_types=1);

namespace App\Solvers\AdventOfCode2020;

use App\DataStructures\Graph\Algorithms\Reachability;
use App\DataStructures\Graph\Graph;
use App\DataStructures\Graph\Vertex;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class Day7 extends AbstractSolver
{
    private Graph $graph;

    public function __construct()
    {
        parent::__construct();

        $this->graph = new Graph();
    }

    protected function partOne(string $input)
    {
        Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => $this->parseLine($line));

        return Reachability::make($this->graph)
            ->verticesThatCanReach($this->graph->vertices->get('shiny gold'))
            ->count();
    }

    protected function partTwo(string $input)
    {
        Str::of($input)
            ->explode("\n")
            ->filter()
            ->map(fn($line) => $this->parseLine($line));

        return $this->walkTreeDown($this->graph->vertices->get('shiny gold'), 1);
    }

    private function parseLine(string $line)
    {
        $patternMultipleNode = '/(\w+ \w+) bags? contain (\d+) (\w+ \w+) bags?(.*)/';
        $patternNoNodes = '/(\w+ \w+) bags? contain no other bags?\./';

        $matchMultipleNodes = Regex::match($patternMultipleNode, $line);
        if ($matchMultipleNodes->hasMatch()) {
            return $this->createMultipleEdgedVortex($matchMultipleNodes);
        }

        $matchNoNodes = Regex::match($patternNoNodes, $line);
        if ($matchNoNodes->hasMatch()) {
            return $this->createZeroEdgedVortex($matchNoNodes);
        }

        throw new \Exception('Could not parse line: '. $line);
    }

    private function createMultipleEdgedVortex(\Spatie\Regex\MatchResult $matchResult): Vertex
    {
        $vertex = $this->createZeroEdgedVortex($matchResult);

        $vertexOne = $this->getOrCreateVertex($matchResult->group(3));

        $vertex->createDirectedEdgeTo($vertexOne)->setAttribute('count', $matchResult->group(2));

        $this->createEdgedToVertex($matchResult->group(4), $vertex);

        return $vertex;
    }

    private function createEdgedToVertex(string $rest, Vertex $vertex): Vertex
    {
        $pattern = '/(\d+) (\w+ \w+) bags?(.*)/';
        $matchResult = Regex::match($pattern, $rest);

        if ($matchResult->hasMatch()) {
            $vertexTwo = $this->getOrCreateVertex($matchResult->group(2));

            $vertex->createDirectedEdgeTo($vertexTwo)->setAttribute('count', $matchResult->group(1));

            $this->createEdgedToVertex($matchResult->group(3), $vertex);
        }

        return $vertex;
    }

    private function createZeroEdgedVortex(\Spatie\Regex\MatchResult $matchResult): Vertex
    {
        return $this->getOrCreateVertex($matchResult->group(1));
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

    private function walkTreeDown(Vertex $startBag, int $multiplier): int
    {
        $count = 0;

        foreach ($startBag->getEdgesOut() as $edge) {
            $amount = $multiplier * $edge->getAttribute('count');

            $containsAmountBags = $this->walkTreeDown($edge->vertexEnd(), $amount);

            $count += $amount;
            $count += $containsAmountBags;
        }

        return $count;
    }
}
