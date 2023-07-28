<?php

declare(strict_types=1);

namespace GameClient\Action\Dungeon;

use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Component\Player\PlayerState;
use GameClient\Storage\DungeonRepository;
use GameClient\Storage\PlayerRepository;

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
        if ($player->state !== PlayerState::InDungeon) {
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
