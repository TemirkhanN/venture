<?php

declare(strict_types=1);

namespace GameClient\IO;

interface OutputInterface
{
    public function write(string $content): void;
}
