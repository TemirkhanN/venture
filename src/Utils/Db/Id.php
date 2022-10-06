<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Db;

final class Id
{
    public function __construct(private readonly int $id)
    {

    }

    public function value(): int
    {
        return $this->id;
    }
}
