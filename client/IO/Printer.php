<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

class Printer implements OutputInterface
{
    private string $buffer = '';

    public function write(string $content): void
    {
        $this->buffer .= $content;
    }

    public function __destruct()
    {
        echo $this->buffer;
    }
}
