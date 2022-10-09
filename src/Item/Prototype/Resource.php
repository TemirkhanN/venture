<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Venture\Item\ItemInterface as ItemInstance;
use TemirkhanN\Venture\Utils\Id;

class Resource implements ItemInterface
{
    public const ITEM_TYPE = 'resource';

    public function __construct(
        private readonly Id $id,
        private readonly string $name
    )
    {

    }

    // todo keep in mind this approach. might be better might be worse but it has to be a single approach for other items too
    public static function isResource(ItemInterface $item): bool
    {
        return $item->type() === self::ITEM_TYPE;
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

    public function replicate(): ItemInstance
    {
        return new \TemirkhanN\Venture\Item\Resource($this);
    }
}
