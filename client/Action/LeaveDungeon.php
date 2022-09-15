<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Player\Player;

class LeaveDungeon implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'LeaveDungeon';

    public function handle(Player $player, ActionInterface $action): void
    {
        // TODO: Implement handle() method.
    }
}
