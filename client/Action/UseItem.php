<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Player\Player;

class UseItem implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'UseItem';

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $fromSlot = $action->getInput('fromSlot', $action::TYPE_INT);

        foreach ($player->showInventory() as $slot) {
            if ($slot->position === $fromSlot) {
                $item = $slot->item;

                if (!$player->canUseItem($item)) {
                    return;
                }

                $player->useItem($item);
                $player->discardItem($slot);

                return;
            }
        }
    }
}
