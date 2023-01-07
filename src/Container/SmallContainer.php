<?php

namespace App\Container;

class SmallContainer extends AbstractContainer
{
    private string $title = 'Small container';

    protected static function getWidth(): int
    {
        return 150;
    }

    protected static function getLength(): int
    {
        return 100;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}