<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Item\Prototype\ItemInterface as ItemPrototypeInterface;
use TemirkhanN\Venture\Utils\Id;

interface ItemInterface extends ItemPrototypeInterface
{
    public function instanceId(): Id;
}
