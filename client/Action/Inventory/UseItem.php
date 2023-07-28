<?php

declare(strict_types=1);

namespace GameClient\Action\Inventory;

use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Storage\GameLogRepository;

class UseItem implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'UseItem';

    public function __construct(private readonly GameLogRepository $gameLogRepository) {}

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $fromSlot = $action->getInput('fromSlot', $action::TYPE_INT);

        $result = $player->player->useItem($fromSlot, 1);

        if (!$result->isSuccessful()) {
            $this->gameLogRepository->addLog($result->getError());
        }
    }
}
