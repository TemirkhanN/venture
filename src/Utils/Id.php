<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils;

final class Id
{
    private readonly string $id;

    public function __construct(string|int $id)
    {
        $identifier = (string) $id;

        if ($identifier === '') {
            throw new \LogicException('Id can not be empty');
        }

        $this->id = $identifier;
    }

    public static function generate(string $prefix = ''): self
    {
        return new self(uniqid($prefix, true));
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
