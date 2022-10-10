<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Battle;

use TemirkhanN\Venture\Character\Action\Attack as AttackAction;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Storage\BattleRepository;
use TemirkhanN\Venture\Player\Player;

class Attack implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'AttackEnemy';

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
