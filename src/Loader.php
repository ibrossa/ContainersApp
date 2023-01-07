<?php

namespace App;

use App\Object\ObjectInterface;
use App\Container\ContainerInterface;

class Loader
{
    private array $objects = [];
    private array $containers = [];
    private string|null $result = null;

    /**
     * Method for adding new object to class
     *
     * @param ObjectInterface $object
     * @return void
     */
    public function addObject(ObjectInterface $object): void
    {
        $this->objects[] = $object;
        usort($this->objects, function ($a, $b) {
            return $a->getArea() <=> $b->getArea();
        });
        $this->objects = array_reverse($this->objects);
    }

    /**
     * Method for adding new container to class
     *
     * @param ContainerInterface $container
     * @param int $number
     * @return void
     */
    public function addContainer(ContainerInterface $container, int $number = 1): void
    {
        for ($i = 0; $i < $number; $i++) {
            $this->containers[] = $container;
        }
        usort($this->containers, function ($a, $b) {
            return $a->getArea() <=> $b->getArea();
        });
    }

    /**
     * Method for getting sum of all objects area
     *
     * @return int
     */
    public function getObjectsArea(): int
    {
        $area = 0;
        foreach ($this->objects as $object) {
            $area += $object->getArea();
        }

        return $area;
    }

    /**
     * Method for getting sum of all containers area
     *
     * @return int
     */
    public function getContainersArea(): int
    {
        $area = 0;
        foreach ($this->containers as $container) {
            $area += $container->getArea();
        }

        return $area;
    }

    /**
     * Method for calculating how many containers required for objects.
     *
     * @return string|null
     */
    public function calculate(): ?string
    {
        $this->checkIfSetObjectsAndContainers();

        if ($this->result == null) {
            $this->checkIfBiggestObjectCanFitBiggestContainer();
        }
        if ($this->result == null) {
            $this->checkIfEnoughArea();
        }
        if ($this->result == null) {
            $this->checkIfFitInOneContainer();
        }
        if ($this->result == null) {
            $this->checkIfFitInAllContainers();
        }

        return $this->result;
    }

    /**
     * Method for checking if we can make calculation
     *
     * @return void
     */
    protected function checkIfSetObjectsAndContainers():void
    {
        if (empty($this->objects)) {
            $this->result = 'Add to class at least One object';
        }
        if (empty($this->containers)) {
            $this->result = 'Add to class at least One container';
        }
    }

    /**
     * Checking area of containers for having enough place for all objects
     *
     * @return void
     */
    protected function checkIfEnoughArea(): void
    {
        if ($this->getContainersArea() - $this->getObjectsArea() < 0) {
            $this->result = "Sorry we don't have enough containers. Please add more containers";
        }
    }

    /**
     * Checking if exists object with greater area then container's area
     *
     * @return void
     */
    protected function checkIfBiggestObjectCanFitBiggestContainer(): void
    {
        $all_containers = $this->containers;
        $biggest_container = array_pop($all_containers);
        $all_objects = $this->objects;
        $biggest_object = array_shift($all_objects);

        $biggest_container->resetRemainingArea();

        if (!$biggest_container->canFitObject($biggest_object)) {
            $this->result = 'The biggest object is to big for biggest container!';
        }
    }

    /**
     * Method for checking if all object can fit in one container. Checking from the smallest container.
     *
     * @return void
     */
    protected function checkIfFitInOneContainer(): void
    {
        foreach ($this->containers as $container)
        {
            if ($container->getArea() > $this->getObjectsArea()) {
                $this->result = 'All the objects wil get in one '. $container->getTitle();
                break;
            }
        }
    }

    /**
     * Method for checking if can put all objects in some or all containers
     *
     * @return void
     */
    protected function checkIfFitInAllContainers(): void
    {

        $all_containers = array_reverse($this->containers);
        $used_containers = [];

        foreach ($all_containers as $container) {
            $container->resetRemainingArea();
            foreach ($this->objects as $key => $object) {
                if ($container->canFitObject($object)) {
                    unset($this->objects[$key]);
                }
            }
            $used_containers[] = $container;

            if(empty($this->objects)) break;
        }
        if (!empty($this->objects)) {
            $this->result = "Sorry we don't have enough space in containers. Please add more containers";
        }

        $this->prepareResult($used_containers);
    }

    /**
     * Method for generating resul message according result of containers
     *
     * @param $used_containers
     * @return void
     */
    protected function prepareResult($used_containers): void
    {
        $data= [];
        foreach ($used_containers as $container){
            $data[] = $container->getTitle();
        }

        $result = 'You will need:';
        foreach (array_count_values($data) as $key => $item) {
            $result .= $item.'x '.$key.' ';
        }

        $this->result = $result;
    }
}