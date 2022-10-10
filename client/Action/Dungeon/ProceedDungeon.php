<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Dungeon;

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Component\Player\PlayerState;
use TemirkhanN\Venture\Game\Storage\BattleRepository;
use TemirkhanN\Venture\Game\Storage\DungeonRepository;

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
