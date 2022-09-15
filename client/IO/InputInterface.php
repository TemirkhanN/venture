<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

interface InputInterface
{
    public function getString(string $key): string;

    public function getInt(string $key): int;

    public function get(string $key): mixed;
}
