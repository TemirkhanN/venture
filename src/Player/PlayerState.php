<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

enum PlayerState: string
{
    case Idle = 'idle';
    case InDungeon = 'inDungeon';
    case Fighting = 'inFight';
    case Crafting = 'isCrafting';
}
