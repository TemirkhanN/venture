<?php

declare(strict_types=1);

namespace GameClient\Action\Inventory;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;

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
