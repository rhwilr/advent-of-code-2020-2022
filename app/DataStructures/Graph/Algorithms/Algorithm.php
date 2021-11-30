<?php

namespace App\DataStructures\Graph\Algorithms;

use App\DataStructures\Graph\Graph;

abstract class Algorithm
{
    protected Graph $graph;

    /**
     * @param Graph $graph
     */
    public static function make(Graph $graph): static
    {
        return new static($graph);
    }

    /**
     * @param Graph $graph
     */
    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }
}
