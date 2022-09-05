<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Armor implements ItemInterface
{
    public function __construct(
        public readonly string $name,
        public readonly int $defence,
        public readonly int $health = 0
    )
    {

    }

    public function name(): string
    {
        return $this->name;
    }
}
