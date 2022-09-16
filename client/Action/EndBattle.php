<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Game\Storage\BattleRepository;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;

class EndBattle implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'EndBattle';

    public function __construct(
        private readonly BattleRepository $battleRepository
    ) {}

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $battle = $this->battleRepository->find($player);
        if ($battle === null) {
            return;
        }


        if (!$battle->isOver()) {
            return;
        }

        if ($battle->player()->isAlive() && !$battle->enemy()->isAlive()) {
            $player->receiveReward($battle);
        }

        $player->state = PlayerState::InDungeon;

        $this->battleRepository->end($battle);
    }
}
