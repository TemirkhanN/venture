<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use TemirkhanN\Venture\Character\Stats;

interface TargetInterface
{
    public function name(): string;
    public function isAlive(): bool;
    public function stats(): Stats;
}
