<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Venture\Utils\Id;

interface ItemInterface
{
    public function id(): Id;
    public function type(): string;
    public function name(): string;
}
