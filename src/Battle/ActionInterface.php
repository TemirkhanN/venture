<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use TemirkhanN\Venture\Utils\Generic\Result;

interface ActionInterface
{
    public function perform(Battle $at): Result;
}
