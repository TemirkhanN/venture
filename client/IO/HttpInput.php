<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

class HttpInput implements InputInterface
{
    private array $raw;

    public function __construct(array $rawInput)
    {
        $this->raw = $rawInput;
    }

    public function getString(string $key): string
    {
        $value = $this->raw[$key] ?? '';

        if (!is_string($value)) {
            throw new \RuntimeException(sprintf('%s expected to be string %s given', $key, gettype($value)));
        }

        return $value;
    }
}
