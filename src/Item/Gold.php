<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Gold implements ItemInterface
{
    public function type(): string
    {
        return 'currency';
    }

    public function name(): string
    {
        return 'Gold';
    }
}
