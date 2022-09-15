<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Player\Player;

class EquipItem implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'EquipItem';

    public function handle(Player $player, InputInterface $input): void
    {
        if ($input->getAction() !== self::ACTION_NAME) {
            return;
        }

        $fromSlot = $input->getInt('fromSlot');

        foreach ($player->showInventory() as $slot) {
            if ($slot->position === $fromSlot) {
                $item = $slot->item;

                if (!EquipmentItem::isEquipmentItem($item)) {
                    // TODO notice?
                    return;
                }

                $player->equip(EquipmentItem::autoDetect($item));
            }
        }
    }
}
