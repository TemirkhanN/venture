<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Battle;

use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Component\Player\PlayerState;
use TemirkhanN\Venture\Game\Storage\BattleRepository;
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
