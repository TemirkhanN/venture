<?php

declare(strict_types=1);

namespace GameClient\Action\Dungeon;

use TemirkhanN\Venture\Battle\Battle;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Component\Player\PlayerState;
use GameClient\Storage\BattleRepository;
use GameClient\Storage\DungeonRepository;

class ProceedDungeon implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'ProceedDungeon';

    public function __construct(
        private readonly DungeonRepository $dungeonRepository,
        private readonly BattleRepository $battleRepository
    ) {

    }

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($player->state !== PlayerState::InDungeon) {
            return;
        }

        $dungeon = $this->dungeonRepository->find($player);
        if ($dungeon === null) {
            $player->state = PlayerState::Idle;

            return;
        }

        $currentStage = $dungeon->currentStage();
        if ($currentStage === null) {
            $player->state = PlayerState::Idle;

            return;
        }

        foreach ($currentStage->monsters() as $monster) {
            if ($monster->isAlive()) {
                $battle = new Battle($player->player, $monster);
                $player->state = PlayerState::Fighting;
                $this->battleRepository->save($battle);

                return;
            }
        }
    }
}
