<?php

namespace App\DataStructures\Graph;

use App\DataStructures\Graph\Edge\Directed;
use App\DataStructures\Graph\Edge\Edge;
use App\DataStructures\Graph\Edge\Undirected;
use Illuminate\Support\Collection;

class Vertex
{
    use HasAttributes;

    /**
     * @var Graph
     */
    private Graph $graph;

    /**
     * @var string|int
     */
    private string|int $id;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var Collection
     */
    private Collection $edges;

    /**
     * @param Graph $graph
     * @param $id
     * @param Collection|null $attributes
     */
    public function __construct(Graph $graph, $id)
    {
        $this->graph = $graph;
        $this->id = $id;

        $this->edges = collect();
    }

    /**
     * @return int|string
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    public function addEdge(Edge $edge)
    {
        $this->edges->push($edge);
    }

    public function createUndirectedEdgeTo(Vertex $vertex): Undirected
    {
        return new Undirected($this, $vertex);
    }

    public function createDirectedEdgeTo(Vertex $vertex): Directed
    {
        return new Directed($this, $vertex);
    }

    /**
     * @return Edge[]
     */
    public function getEdgesOut(): Collection
    {
        return $this->edges
            ->filter(fn (Edge $edge) => $edge->vertexFrom($this))
            ->filter();
    }

    /**
     * @return Edge[]
     */
    public function getEdgesIn(): Collection
    {
        return $this->edges
            ->filter(fn (Edge $edge) => $edge->vertexTo($this))
            ->filter();
    }
}
