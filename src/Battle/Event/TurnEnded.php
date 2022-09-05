<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle\Event;

use TemirkhanN\Venture\Battle\Battle;

class TurnEnded
{
    public function __construct(public readonly Battle $battle)
    {

    }
}
