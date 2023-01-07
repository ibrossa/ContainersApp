<?php

namespace App\Container;

use App\Object\ObjectInterface;

interface ContainerInterface
{
    public function getTitle();
    public function getArea();
    public function resetRemainingArea();
    public function canFitObject(ObjectInterface $object);
}