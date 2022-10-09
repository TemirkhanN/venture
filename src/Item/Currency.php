<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Item\Prototype\Currency as CurrencyPrototype;
use TemirkhanN\Venture\Utils\Id;

class Currency implements ItemInterface
{
    use ItemInstanceTrait;

    public function __construct(CurrencyPrototype $currency)
    {
        $this->id = $currency->id();
        $this->type = $currency->type();
        $this->name = $currency->name();
        $this->instanceId = Id::generate($this->type);
    }
}
