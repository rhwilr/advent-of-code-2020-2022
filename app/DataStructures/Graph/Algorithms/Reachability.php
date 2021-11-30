<?php

namespace App\DataStructures\Graph\Algorithms;

use App\DataStructures\Graph\Vertex;
use Illuminate\Support\Collection;

class Reachability extends Algorithm
{
    public function reachableVerticesStartingFrom(Vertex $vertex): Collection
    {
        $collect = collect();

        foreach ($vertex->getEdgesOut() as $edge) {
            $targetVertex = $edge->vertexFrom($vertex);

            if (!is_null($targetVertex)) {
                $collect->put($targetVertex->getId(), $targetVertex);

                $collect = $collect->merge($this->reachableVerticesStartingFrom($targetVertex));
            }
        }

        return $collect;
    }

    public function verticesThatCanReach(Vertex $vertex): Collection
    {
        $collect = collect();

        foreach ($vertex->getEdgesIn() as $edge) {
            $targetVertex = $edge->vertexTo($vertex);

            if (!is_null($targetVertex)) {
                $collect->put($targetVertex->getId(), $targetVertex);

                $collect = $collect->merge($this->verticesThatCanReach($targetVertex));
            }
        }

        return $collect;
    }
}
