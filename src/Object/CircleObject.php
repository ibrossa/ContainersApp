<?php

namespace App\Object;

class CircleObject implements ObjectInterface
{
    public int $radius;
    public function __construct(int $radius)
    {
        $this->radius = $radius;
    }

    /**
     * Method to get circle area
     *
     * @return int
     */
    public function getArea(): int
    {
        return $this->radius * 2;
    }
}