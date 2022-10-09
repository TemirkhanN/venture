<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Item\Prototype\Armor as ArmorPrototype;
use TemirkhanN\Venture\Utils\Id;

class Armor implements ItemInterface
{
    use ItemInstanceTrait;

    private readonly int $defence;
    private readonly int $health;

    public function __construct(ArmorPrototype $prototype)
    {
        $this->id         = $prototype->id();
        $this->name       = $prototype->name();
        $this->type       = $prototype->type();
        $this->instanceId = Id::generate($this->type);
        $this->defence    = $prototype->defence;
        $this->health     = $prototype->health;
    }

    public function defence(): int
    {
        return $this->defence;
    }

    public function health(): int
    {
        return $this->health;
    }
}
