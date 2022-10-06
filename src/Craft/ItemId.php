<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Venture\Utils\Db\Id;

class ItemId
{
    public function __construct(public readonly Id $id){}
}
