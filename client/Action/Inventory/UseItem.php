<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Inventory;

use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Storage\GameLogRepository;
use TemirkhanN\Venture\Player\Inventory\Slot;
use TemirkhanN\Venture\Player\Player;

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

        $result = $player->useItem($fromSlot, 1);

        if (!$result->isSuccessful()) {
            $this->gameLogRepository->addLog($result->getError());
        }
    }
}
