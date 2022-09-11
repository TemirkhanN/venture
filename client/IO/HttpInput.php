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

    public function getInt(string $key): int
    {
        $value = $this->raw[$key] ?? 0;

        if (!is_numeric($value)) {
            throw new \RuntimeException(sprintf('%s expected to be numeric %s given', $key, $value));
        }

        return (int) $value;
    }

    public function getAction(): string
    {
        return $this->getString('action');
    }

    public function hasAction(): bool
    {
        return $this->getAction() !== '';
    }
}
