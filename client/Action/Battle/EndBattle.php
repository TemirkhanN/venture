<?php

declare(strict_types=1);

namespace GameClient\Action\Battle;

use Psr\EventDispatcher\EventDispatcherInterface;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Component\Player\PlayerState;
use GameClient\Storage\BattleRepository;
use TemirkhanN\Venture\Npc\Event\NpcKilled;

readonly class EndBattle implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'EndBattle';

    public function __construct(
        private BattleRepository         $battleRepository,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $battle = $this->battleRepository->find($player);
        if ($battle === null) {
            return;
        }

        $enemy = $battle->enemy();
        if ($player->player->isAlive() && !$enemy->isAlive()) {
            $this->eventDispatcher->dispatch(new NpcKilled($enemy, $player->player));
        }

        // Enemy has to restore health to prevent player from using attack=>flee exploit
        if ($enemy->isAlive()) {
            $enemy->restoreHp();
        }

        // @todo FSM
        $player->state = PlayerState::InDungeon;

        $this->battleRepository->end($battle);
    }
}
