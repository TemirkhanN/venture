<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Game\Component\Player\Player;

interface PlayerActionHandlerInterface
{
    public function handle(Player $player, ActionInterface $action): void;
}
