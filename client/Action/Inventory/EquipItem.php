<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Inventory;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;

class EquipItem implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'EquipItem';

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $fromSlot = $action->getInput('fromSlot', $action::TYPE_INT);

        foreach ($player->player->showInventory() as $slot) {
            if ($slot->position === $fromSlot) {
                $item = $slot->item;

                if (!EquipmentItem::isEquipmentItem($item)) {
                    // TODO notice?
                    return;
                }

                $player->player->equip(EquipmentItem::autoDetect($item));

                return;
            }
        }
    }
}
