<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

enum PlayerState: string
{
    case Idle = 'idle';
    case InDungeon = 'in_dungeon';
    case InFight = 'in fight';

    public function isIdle(): bool
    {
        return $this == self::Idle;
    }
}
