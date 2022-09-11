<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\IO;

class Printer implements OutputInterface
{
    public function write(string $content): void
    {
        echo $content;
    }
}
