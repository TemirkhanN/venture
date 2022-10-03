<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Craft;

use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;

class ToggleCraftMenu implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'ToggleCraftMenu';

    public function __construct(private readonly PlayerRepository $playerRepository) {}

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $status = $action->getInput('status', ActionInterface::TYPE_STRING);

        if ($status === 'on' && $player->isIdle()) {
            $newState = PlayerState::Crafting;
        }

        if ($status === 'off' && $player->isCrafting()) {
            $newState = PlayerState::Idle;
        }

        if (!isset($newState)) {
            return;
        }

        $player->state = $newState;
        $this->playerRepository->save($player);
    }
}
