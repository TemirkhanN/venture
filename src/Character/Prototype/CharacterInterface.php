<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Prototype;

use TemirkhanN\Venture\Character\Stats\StatsInterface;
use TemirkhanN\Venture\Utils\Id;

interface CharacterInterface
{
    public function id(): Id;
    public function name(): string;
    public function stats(): StatsInterface;
    public function lvl(): int;
}
