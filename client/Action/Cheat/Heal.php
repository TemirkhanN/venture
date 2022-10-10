<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Cheat;

use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;

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
