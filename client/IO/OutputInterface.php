<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

interface OutputInterface
{
    public function write(string $content): void;
}
