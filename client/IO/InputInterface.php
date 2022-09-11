<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

interface InputInterface
{
    public function getString(string $key): string;

    public function getInt(string $key): int;

    public function getAction(): string;

    public function hasAction(): bool;
}
