<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Weapon implements ItemInterface
{
    use TypeCasterTrait;

    public const ITEM_TYPE = 'weapon';

    public function __construct(
        public readonly string $name,
        public readonly int $attack
    )
    {

    }

    public function type(): string
    {
        return self::ITEM_TYPE;
    }

    public function name(): string
    {
        return $this->name;
    }
}
