<?php

declare(strict_types=1);

namespace GameClient\IO;

class Printer implements OutputInterface
{
    private string $buffer = '';

    public function write(string $content): void
    {
        $this->buffer .= $content;
    }

    public function flush(): string
    {
        $buffer = $this->buffer;
        $this->buffer = '';

        return $buffer;
    }
}
