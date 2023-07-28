<?php

declare(strict_types=1);

namespace GameClient\Action\Cheat;

use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Storage\PlayerRepository;

class Heal implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'cheat_restore_hp';

    public function __construct(private readonly PlayerRepository $playerRepository) {}


    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $stats = $player->player->stats();

        $player->player->restoreHp($stats->maxHealth() - $stats->currentHealth());

        $this->playerRepository->save($player);
    }
}
