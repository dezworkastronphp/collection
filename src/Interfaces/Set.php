<?php

namespace Astronphp\Collection\Interfaces;

interface Set
{
    public function union();
    public function diff();
    public function intersect();
    public function cartesian();
}