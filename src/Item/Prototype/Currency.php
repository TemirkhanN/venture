<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Venture\Utils\Id;

class Currency implements ItemInterface
{
    public const ITEM_TYPE = 'currency';

    public const CURRENCY_NAME_GOLD = 'Gold';

    public function __construct(private readonly Id $id, private readonly string $name)
    {

    }

    public function id(): Id
    {
        return $this->id;
    }

    // TODO likely should be exposed on repository level or infra-related layer
    public static function gold(): self
    {
        return new self(new Id('1'), self::CURRENCY_NAME_GOLD);
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
