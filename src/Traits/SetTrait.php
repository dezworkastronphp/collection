<?php

namespace Astronphp\Collection\Traits;

trait SetTrait
{
    /**
     * Perform a union of sets
     * 
     * @return self
     */
    public function union(): self
    {
        return $this->merge()->unique();
    }

    /**
     * Perform a difference of sets
     * 
     * @return self
     */
    public function diff(): self
    {   
        return $this->reduce(function($a, $b) {
            return array_diff($a->toArray(), $b->toArray());
        });
    }

    /**
     * Perform a full difference of sets
     * 
     * @return self
     */
    public function outer(): self
    {   
        return $this->return([
            $this->diff()->values()->toArray(),
            $this->reverse()->diff()->values()->toArray(),
        ]);
    }

    /**
     * Perform a intersection of sets
     * 
     * @return self
     */
    public function intersect(): self
    {
        return $this->reduce(function($a, $b) {
            return array_intersect($a->toArray(), $b->toArray());
        });
    }

    /**
     * Perform a cartesian product of sets
     * 
     * @return self
     */
    public function cartesian(): self
    {
        $cartesian = [[]];
        foreach ($this->content as $key => $values) {
            $append = [];
            foreach ($cartesian as $product) {
                foreach ($values as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }
            $cartesian = $append;
        }
        return $this->return($cartesian);
    }
}