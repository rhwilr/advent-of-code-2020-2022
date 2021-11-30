<?php

namespace App\DataStructures\Graph\Edge;

use App\DataStructures\Graph\Vertex;

class Directed extends Edge
{
    /**
     * Returns the vertex that is on the other side going out
     *
     * @param Vertex $vertex
     * @return Vertex|null
     */
    public function vertexFrom(Vertex $vertex): ?Vertex
    {
        if ($this->vertexA === $vertex) {
            return $this->vertexB;
        }

        return null;
    }

    /**
     * Returns the vertex that is pointing to the passed vertex via this edge
     *
     * @param Vertex $vertex
     * @return Vertex|null
     */
    public function vertexTo(Vertex $vertex): ?Vertex
    {
        if ($this->vertexB === $vertex) {
            return $this->vertexA;
        }

        return null;
    }

    /**
     * Get end/target vertex
     *
     * @return Vertex
     */
    public function vertexEnd()
    {
        return $this->vertexB;
    }

    /**
     * Get start vertex
     *
     * @return Vertex
     */
    public function vertexStart()
    {
        return $this->vertexA;
    }
}
