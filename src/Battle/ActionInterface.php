<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

interface ActionInterface
{
    public function perform(Battle $at): void;
}
