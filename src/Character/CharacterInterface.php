<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Battle\TargetInterface;
use TemirkhanN\Venture\Drop\Loot;
use TemirkhanN\Venture\Item\Prototype\ItemInterface;
use TemirkhanN\Venture\Player\Inventory\Slot;
use TemirkhanN\Venture\Utils\Generic\ImmutableList;
use TemirkhanN\Venture\Utils\Generic\Result;

interface CharacterInterface extends TargetInterface, ProgressInterface
{
    public function loseHp(int $amount): void;
    public function restoreHp(int $amount): void;
    /**
     * @return iterable<Slot>
     */
    public function showInventory(): iterable;
    /**
     * @return ImmutableList<Equipment\EquipmentItem>
     */
    public function equipment(): ImmutableList;

    public function equip(Equipment\EquipmentItem $item): void;
    public function canEquip(ItemInterface $item): bool;

    public function loot(Loot $loot): Result;
    public function discardItem(int $slotPosition, ?int $amount = null): Result;

    public function useItem(int $inSlot, int $amount): Result;
}
