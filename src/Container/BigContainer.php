<?php

namespace App\Container;

class BigContainer extends AbstractContainer
{
    private string $title = 'Big container';

    protected static function getWidth(): int
    {
        return 800;
    }

    protected static function getLength(): int
    {
        return 200;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

}