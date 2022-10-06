<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils;

final class Id
{
    private readonly string $id;

    public function __construct(string|int $id)
    {
        $this->id = (string) $id;
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
