<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Item\Prototype\Resource as ResourcePrototype;
use TemirkhanN\Venture\Utils\Id;

class Resource implements ItemInterface
{
    use ItemInstanceTrait;

    public function __construct(ResourcePrototype $resource)
    {
        $this->id = $resource->id();
        $this->type = $resource->type();
        $this->name = $resource->name();
        $this->instanceId = Id::generate($this->type);
    }
}
