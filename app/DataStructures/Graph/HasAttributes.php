<?php

namespace App\DataStructures\Graph;

use App\DataStructures\Graph\Edge\Edge;
use Illuminate\Support\Collection;

trait HasAttributes
{
    /**
     * @var Collection
     */
    private Collection $attributes;

    private function initializeAttributes()
    {
        if (!isset($this->attributes)) {
            $this->attributes = collect();
        }
    }

    /**
     * @param Collection $attributes
     * @return static
     */
    public function setAttributes(Collection $attributes): static
    {
        $this->initializeAttributes();

        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        $this->initializeAttributes();

        return $this->attributes;
    }

    /**
     * @param string $key
     * @param $value
     * @return static
     */
    public function setAttribute(string $key, $value): static
    {
        $this->initializeAttributes();

        $this->attributes->put($key, $value);

        return $this;
    }


    public function getAttribute(string $key)
    {
        $this->initializeAttributes();

        return $this->attributes->get($key);
    }
}
