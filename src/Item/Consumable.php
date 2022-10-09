<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Item\Effect\EffectInterface;
use TemirkhanN\Venture\Item\Prototype\Consumable as ConsumablePrototype;
use TemirkhanN\Venture\Utils\Generic\ImmutableList;
use TemirkhanN\Venture\Utils\Id;

class Consumable implements ItemInterface
{
    use ItemInstanceTrait;

    private readonly ImmutableList $effects;

    public function __construct(ConsumablePrototype $consumable)
    {
        $this->id = $consumable->id();
        $this->type = $consumable->type();
        $this->name = $consumable->name();
        $this->instanceId = Id::generate($this->type);
        $this->effects = $consumable->effects();
    }

    /**
     * @return ImmutableList<EffectInterface>
     */
    public function effects(): ImmutableList
    {
        return $this->effects;
    }
}
