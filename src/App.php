<?php

namespace App;

use App\Container\BigContainer;
use App\Container\SmallContainer;
use App\Object\CircleObject;
use App\Object\SquareObject;

class App
{
    /**
     * Result for first transport
     *
     * @return void
     */
    public function firstTransport(): void
    {
        $objects = [
            new CircleObject(50),
            new CircleObject(50),
            new SquareObject(100, 100)
        ];

        $loader = $this->prepareCalculatorClass($objects);

        echo 'First transport: '. $loader->calculate(). PHP_EOL;
    }

    /**
     * Result for second transport
     *
     * @return void
     */
    public function secondTransport(): void
    {
        $objects = [
            new SquareObject(400, 400),
            new CircleObject(100)
        ];

        $loader = $this->prepareCalculatorClass($objects);

        echo 'Second transport: '. $loader->calculate(). PHP_EOL;
    }

    /**
     * Result for third transport
     *
     * @return void
     */
    public function thirdTransport(): void
    {
        $objects = [
            new SquareObject(150, 100),
            new SquareObject(50, 50),
            new CircleObject(50)
        ];

        $loader = $this->prepareCalculatorClass($objects);

        echo 'Third  transport: '. $loader->calculate(). PHP_EOL;
    }

    /**
     * Prepare Loader class. Adding all objects and basic containers to Loader
     *
     * @param $objects
     * @return Loader
     */
    public function prepareCalculatorClass($objects): Loader
    {
        $smallContainer = new SmallContainer();
        $bigContainer = new BigContainer();

        $loader = new Loader();
        $loader->addContainer($smallContainer, 2);
        $loader->addContainer($bigContainer);
        foreach ($objects as $object) {
            $loader->addObject($object);
        }

        return $loader;
    }
}