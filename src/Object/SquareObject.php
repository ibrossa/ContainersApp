<?php

namespace App\Object;

class SquareObject implements ObjectInterface
{
    public int $width;
    public int $length;

    public function __construct(int $width, int $length)
    {
        $this->length = $length;
        $this->width = $width;
    }

    /**
     * Method to get square area
     *
     * @return int
     */
    public function getArea(): int
    {
       return $this->width * $this->length;
    }
}