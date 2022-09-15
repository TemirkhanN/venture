<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Game\Storage\BattleRepository;
use TemirkhanN\Venture\Game\Storage\DungeonRepository;
use TemirkhanN\Venture\Player\Action\EngageBattle;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;

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
        if (!$player->isInDungeon()) {
            return;
        }

        $dungeon = $this->dungeonRepository->find();
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
                $battle = new Battle($monster);
                $battle->applyAction(new EngageBattle($player));
                $this->battleRepository->save($battle);

                return;
            }
        }
    }
}
