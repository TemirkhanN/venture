<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

interface ProgressInterface
{
    public function lvl(): int;
    public function exp(): int;
    public function nextLvlExp(): int;
}
