<?php

namespace App\DataStructures\Graph\Edge;

use App\DataStructures\Graph\Vertex;

class Undirected extends Edge
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

        if ($this->vertexB === $vertex) {
            return $this->vertexA;
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
        if ($this->vertexA === $vertex) {
            return $this->vertexB;
        }

        if ($this->vertexB === $vertex) {
            return $this->vertexA;
        }

        return null;
    }
}
