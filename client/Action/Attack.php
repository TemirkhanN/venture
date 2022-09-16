<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

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

        $battle = $this->battleRepository->find();
        if ($battle === null) {
            return;
        }

        $battle->applyAction(new \TemirkhanN\Venture\Player\Action\Attack());

        $this->battleRepository->save($battle);
    }
}
