<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Utils\Id;

class Resource implements ItemInterface
{
    public const ITEM_TYPE = 'resource';

    public function __construct(
        public readonly Id $id,
        public readonly string $name
    )
    {

    }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return self::ITEM_TYPE;
    }
}
