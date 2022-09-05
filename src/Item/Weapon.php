<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Weapon implements ItemInterface
{
    public function __construct(
        public readonly string $name,
        public readonly int $damage
    )
    {

    }

    public function name(): string
    {
        return $this->name;
    }
}
