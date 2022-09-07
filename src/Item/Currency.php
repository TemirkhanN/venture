<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Currency implements ItemInterface
{
    public const ITEM_TYPE = 'currency';

    public const CURRENCY_NAME_GOLD = 'Gold';

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function gold(): self
    {
        return new self(self::CURRENCY_NAME_GOLD);
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
