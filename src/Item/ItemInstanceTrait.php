<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Utils\Id;
use TemirkhanN\Venture\Utils\InstanceTrait;

trait ItemInstanceTrait
{
    use InstanceTrait;

    private readonly Id $id;
    private readonly string $name;
    private readonly string $type;

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
        return $this->type;
    }

    public function replicate(): ItemInterface
    {
        throw new \LogicException('Item instance can not be used for replication. Only prototype can do that.');
    }
}
