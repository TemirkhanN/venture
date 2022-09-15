<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

class HttpInput implements InputInterface
{
    private array $raw;

    public function __construct(array $rawInput = [])
    {
        $this->raw = $rawInput;
    }

    public static function json(): self
    {
        $phpInput = file_get_contents('php://input');
        $input = json_decode($phpInput, true);

        if (!is_array($input)) {
            $input = [];
        }

        return new self($input);
    }

    public function getString(string $key): string
    {
        $value = $this->get($key) ?? '';

        if (!is_string($value)) {
            throw new \RuntimeException(sprintf('%s expected to be string %s given', $key, gettype($value)));
        }

        return $value;
    }

    public function getInt(string $key): int
    {
        $value = $this->get($key) ?? 0;

        if (!is_numeric($value)) {
            throw new \RuntimeException(sprintf('%s expected to be numeric %s given', $key, $value));
        }

        return (int) $value;
    }

    public function get(string $key): mixed
    {
        return $this->raw[$key] ?? null;
    }
}
