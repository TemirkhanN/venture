<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Battle\TargetInterface;
use TemirkhanN\Venture\Item\Prototype\ItemInterface;
use TemirkhanN\Venture\Player\Inventory\Slot;

interface CharacterInterface extends TargetInterface, ProgressInterface
{
    public function loseHp(int $amount): void;
    public function restoreHp(int $amount): void;
    /**
     * @return iterable<Slot>
     */
    public function showInventory(): iterable;
    /**
     * @return iterable<Equipment\EquipmentItem>
     */
    public function equipment(): iterable;

    public function equip(Equipment\EquipmentItem $item): void;
    public function canEquip(ItemInterface $item): bool;

    public function discardItem(Slot $slot): void;

    public function useItem(Slot $fromSlot): void;
}
