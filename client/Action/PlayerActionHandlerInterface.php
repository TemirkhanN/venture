<?php

declare(strict_types=1);

namespace GameClient\Action;

use GameClient\Component\Player\Player;

interface PlayerActionHandlerInterface
{
    public function handle(Player $player, ActionInterface $action): void;
}
