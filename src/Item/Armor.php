<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Utils\Id;

class Armor implements ItemInterface
{
    use TypeCasterTrait;

    public const ITEM_TYPE = 'armor';

    public function __construct(
        public readonly Id $id,
        public readonly string $name,
        public readonly int $defence,
        public readonly int $health = 0
    )
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
}
