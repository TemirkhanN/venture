<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Game\Storage\DungeonRepository;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;

class LeaveDungeon implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'LeaveDungeon';

    public function __construct(
        private readonly DungeonRepository $dungeonRepository,
        private readonly PlayerRepository $playerRepository
    )
    {

    }

    public function handle(Player $player, ActionInterface $action): void
    {
        if (!$player->isInDungeon()) {
            return;
        }

        $dungeon = $this->dungeonRepository->find($player);
        if ($dungeon === null) {
            return;
        }

        $this->dungeonRepository->close($dungeon);

        // TODO event driven
        $player->state = PlayerState::Idle;
        $this->playerRepository->save($player);
    }
}
