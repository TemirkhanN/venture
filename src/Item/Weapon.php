<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Item\Prototype\Weapon as WeaponPrototype;
use TemirkhanN\Venture\Utils\Id;

class Weapon implements ItemInterface
{
    use ItemInstanceTrait;

    private readonly int $attack;

    public function __construct(WeaponPrototype $weapon)
    {
        $this->id         = $weapon->id();
        $this->type       = $weapon->type();
        $this->instanceId = Id::generate($this->type);
        $this->name       = $weapon->name();
        $this->attack     = $weapon->attack;
    }

    public function attack(): int
    {
        return $this->attack;
    }
}
