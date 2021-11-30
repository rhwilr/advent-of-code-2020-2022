<?php

namespace App\DataStructures\Graph\Edge;

use App\DataStructures\Graph\HasAttributes;
use App\DataStructures\Graph\Vertex;

abstract class Edge
{
    use HasAttributes;

    /**
     * @var Vertex
     */
    protected Vertex $vertexA;

    /**
     * @var Vertex
     */
    protected Vertex $vertexB;

    /**
     * @param Vertex $vertexA
     * @param Vertex $vertexB
     */
    public function __construct(Vertex $vertexA, Vertex $vertexB)
    {
        $this->vertexA = $vertexA;
        $this->vertexB = $vertexB;

        $vertexA->addEdge($this);
        $vertexB->addEdge($this);
    }

    /**
     * Returns the vertex that is on the other side going out
     *
     * @param Vertex $vertex
     * @return Vertex|null
     */
    abstract public function vertexFrom(Vertex $vertex): ?Vertex;

    /**
     * Returns the vertex that is pointing to the passed vertex via this edge
     *
     * @param Vertex $vertex
     * @return Vertex|null
     */
    abstract public function vertexTo(Vertex $vertex): ?Vertex;
}
