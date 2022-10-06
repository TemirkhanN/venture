<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Venture\Item\Effect\EffectInterface;
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
     * @return iterable<EffectInterface>
     */
    public function effects(): iterable
    {
        return $this->effects;
    }
}