<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Dungeon;

use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Component\Player\PlayerState;
use TemirkhanN\Venture\Game\Storage\DungeonRepository;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;

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
