<?php

declare(strict_types=1);

namespace GameClient\Action\Battle;

use TemirkhanN\Venture\Character\Action\Attack as AttackAction;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Storage\BattleRepository;

class NextTurn implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'WaitForANextTurn';

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

        $battle->applyAction(new AttackAction());

        $this->battleRepository->save($battle);
    }
}
