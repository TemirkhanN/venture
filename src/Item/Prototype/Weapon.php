<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Venture\Utils\Id;

class Weapon implements ItemInterface
{
    public const ITEM_TYPE = 'weapon';

    public function __construct(
        private readonly Id $id,
        public readonly string $name,
        public readonly int $attack
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
