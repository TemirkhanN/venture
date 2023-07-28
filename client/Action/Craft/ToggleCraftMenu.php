<?php

declare(strict_types=1);

namespace GameClient\Action\Craft;

use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Component\Player\PlayerState;
use GameClient\Storage\PlayerRepository;

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

        if ($status === 'on' && $player->state === PlayerState::Idle) {
            $newState = PlayerState::Crafting;
        }

        if ($status === 'off' && $player->state === PlayerState::Crafting) {
            $newState = PlayerState::Idle;
        }

        if (!isset($newState)) {
            return;
        }

        $player->state = $newState;
        $this->playerRepository->save($player);
    }
}
