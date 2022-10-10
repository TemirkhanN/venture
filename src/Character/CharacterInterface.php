<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Character\Prototype\CharacterInterface as CharacterPrototypeInterface;
use TemirkhanN\Venture\Reward\Loot;
use TemirkhanN\Venture\Item\Prototype\ItemInterface;
use TemirkhanN\Venture\Player\Inventory\Slot;
use TemirkhanN\Venture\Utils\Generic\ImmutableList;
use TemirkhanN\Venture\Utils\Generic\Result;
use TemirkhanN\Venture\Utils\Id;

interface CharacterInterface extends CharacterPrototypeInterface
{
    public function instanceId(): Id;
    public function exp(): int;
    public function nextLvlExp(): int;
    public function isAlive(): bool;
    public function loseHp(int $amount): void;
    public function restoreHp(int $amount): void;
    /**
     * @return ImmutableList<Slot>
     */
    public function showInventory(): ImmutableList;
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
