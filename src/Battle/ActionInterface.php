<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;


use TemirkhanN\Generic\ResultInterface;

interface ActionInterface
{
    public function perform(Battle $at): ResultInterface;
}
