<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Generic\Collection\Collection;
use TemirkhanN\Generic\Collection\CollectionInterface;
use TemirkhanN\Venture\Item\Effect\EffectInterface;
use TemirkhanN\Venture\Item\ItemInterface as ItemInstance;
use TemirkhanN\Venture\Utils\Id;

class Consumable implements ItemInterface
{
    public const ITEM_TYPE = 'consumable';

    /**
     * @param string $name
     * @param array<EffectInterface> $effects
     */
    public function __construct(private readonly Id $id, private readonly string $name, private readonly array $effects)
    {

    }

    public function id(): Id
    {
        return $this->id;
    }

    public function type(): string
    {
        return self::ITEM_TYPE;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return CollectionInterface<EffectInterface>
     */
    public function effects(): CollectionInterface
    {
        return new Collection($this->effects);
    }

    public function replicate(): ItemInstance
    {
        return new \TemirkhanN\Venture\Item\Consumable($this);
    }
}
