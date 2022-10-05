<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Battle;

use TemirkhanN\Venture\Drop\GenerateDrop;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Storage\BattleRepository;
use TemirkhanN\Venture\Game\Storage\GameLogRepository;
use TemirkhanN\Venture\Player\Action\GetBattleRewards;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;
use TemirkhanN\Venture\Utils\Iterating;

class EndBattle implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'EndBattle';

    public function __construct(
        private readonly BattleRepository $battleRepository,
        private readonly GenerateDrop $dropGenerator,
        private readonly GameLogRepository $gameLogRepository
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

        if ($battle->player()->isAlive() && !$battle->enemy()->isAlive()) {
            $logsBeforeAction = Iterating::toArray($battle->logs());
            (new GetBattleRewards($player, $this->dropGenerator))->receiveRewards($battle);
            $logsAfter = array_reverse(Iterating::toArray($battle->logs()));

            foreach (array_slice($logsAfter, count($logsBeforeAction)) as $lootLog) {
                $this->gameLogRepository->addLog($lootLog);
            }
        }

        // Enemy has to restore health to prevent player from using attack=>flee exploit
        if ($battle->enemy()->isAlive()) {
            $battle->enemy()->restoreHp();
        }

        $player->state = PlayerState::InDungeon;

        $this->battleRepository->end($battle);
    }
}
