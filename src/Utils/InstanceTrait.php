<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils;

trait InstanceTrait
{
    private readonly Id $instanceId;

    public function instanceId(): Id
    {
        return $this->instanceId;
    }
}
