<?php

namespace App\Container;

use App\Object\ObjectInterface;

abstract class AbstractContainer implements ContainerInterface
{
    public int $remaining_area;

    abstract protected static function getWidth():int;
    abstract protected static function getLength():int;

    abstract public function getTitle():string;

    public function __construct()
    {
        $this->remaining_area = $this->getArea();
    }

    /**
     * Method for count container's area
     *
     * @return int
     */
    public function getArea(): int
    {
        return static::getWidth()*static::getLength();
    }

    /**
     * Method for resetting remain area of container
     *
     * @return void
     */
    public function resetRemainingArea(): void
    {
        $this->remaining_area = $this->getArea();
    }

    /**
     * Method for checking if enough area for Object
     *
     * @param ObjectInterface $object
     * @return bool
     */
    public function canFitObject(ObjectInterface $object): bool
    {
        if ($this->remaining_area - $object->getArea() < 0) {
            return false;
        }
        $this->remaining_area = $this->remaining_area - $object->getArea();

        return true;
    }
}