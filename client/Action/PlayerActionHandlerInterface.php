<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Player\Player;

interface PlayerActionHandlerInterface
{
    public function handle(Player $player, InputInterface $input): void;
}
