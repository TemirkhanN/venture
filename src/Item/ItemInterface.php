<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

interface ItemInterface
{
    public function type(): string;
    public function name(): string;
}
