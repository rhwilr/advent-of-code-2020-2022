<?php

namespace App\DataStructures\Graph;

use Illuminate\Support\Collection;

class Graph
{
    /**
     * @var Collection
     */
    public Collection $vertices;

    public function __construct()
    {
        $this->vertices = collect();
    }

    /**
     * @param $id
     * @return Vertex
     *
     * @throws \Throwable
     */
    public function createVertex($id): Vertex
    {
        throw_if($this->vertices->has($id));

        $vertex = new Vertex($this, $id);

        $this->vertices->put($id, $vertex);

        return $vertex;
    }
}
