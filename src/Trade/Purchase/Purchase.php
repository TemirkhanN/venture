<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Trade\Purchase;

use TemirkhanN\Venture\Character\CharacterInterface;
use TemirkhanN\Venture\Drop\Loot;
use TemirkhanN\Venture\Player\Inventory\Slot;
use TemirkhanN\Venture\Trade\UnidirectionalTransferInterface;
use TemirkhanN\Venture\Utils\Generic\Result;

class Purchase implements UnidirectionalTransferInterface
{
    public function __construct(private readonly Offer $price, private readonly Offer $acquisition)
    {
        if ($price === $acquisition) {
            throw new \LogicException('Buying the same thing for itself is illegal');
        }
    }

    public function price(): Offer
    {
        return $this->price;
    }

    public function acquisition(): Offer
    {
        return $this->acquisition;
    }

    public function isAffordable(CharacterInterface $to): bool
    {
        if ($this->price->isEmpty()) {
            return true;
        }

        $unfulfilledRequirements = [];
        foreach ($this->price->requirements() as $requirement) {
            $itemId = (string)$requirement->item()->id();
            if (!isset($unfulfilledRequirements[$itemId])) {
                $unfulfilledRequirements[$itemId] = 0;
            }

            $unfulfilledRequirements[$itemId] += $requirement->amount();
        }

        /** @var Slot $slot */
        foreach ($to->showInventory() as $slot) {
            if ($unfulfilledRequirements === []) {
                break;
            }

            if ($slot->isEmpty()) {
                continue;
            }

            $itemId = (string)$slot->item->id();
            if (!isset($unfulfilledRequirements[$itemId])) {
                continue;
            }

            $requiredAmount = $unfulfilledRequirements[$itemId];
            if ($requiredAmount <= $slot->amountOfItems) {
                unset($unfulfilledRequirements[$itemId]);
            } else {
                $unfulfilledRequirements[$itemId] -= $slot->amountOfItems;
            }
        }

        return $unfulfilledRequirements === [];
    }

    public function perform(CharacterInterface $by): Result
    {
        if (!$this->isAffordable($by)) {
            return Result::error('Character can not afford this purchase');
        }

        $unfulfilledRequirements = [];
        foreach ($this->price->requirements() as $requirement) {
            $itemId = (string)$requirement->item()->id();
            if (!isset($unfulfilledRequirements[$itemId])) {
                $unfulfilledRequirements[$itemId] = 0;
            }

            $unfulfilledRequirements[$itemId] += $requirement->amount();
        }

        $itemsToBeUsed = [];
        /** @var Slot $slot */
        foreach ($by->showInventory() as $slot) {
            if ($unfulfilledRequirements === []) {
                break;
            }

            if ($slot->isEmpty()) {
                continue;
            }

            $itemId = (string)$slot->item->id();
            if (!isset($unfulfilledRequirements[$itemId])) {
                continue;
            }

            $requiredAmount = $unfulfilledRequirements[$itemId];
            if ($requiredAmount <= $slot->amountOfItems) {
                $usingAmount = $requiredAmount;
                unset($unfulfilledRequirements[$itemId]);
            } else {
                $usingAmount = $slot->amountOfItems;
                $unfulfilledRequirements[$itemId] -= $slot->amountOfItems;
            }
            $itemsToBeUsed[$slot->position] = $usingAmount;
        }

        foreach ($itemsToBeUsed as $fromSlot => $amount) {
            $discard = $by->discardItem($fromSlot, $amount);
            if (!$discard->isSuccessful()) {
                return Result::error(
                    sprintf('Could not discard item in slot(%d) due to(%s)', $fromSlot, $discard->getError())
                );
            }
        }

        foreach ($this->acquisition->requirements() as $acquisition) {
            // TODO law of Demeter is clearly violated
            $acquired = $by->loot(new Loot($acquisition->item()->replicate(), $acquisition->amount()));

            if (!$acquired->isSuccessful()) {
                return Result::error(
                    sprintf(
                        'Could not acquire item(%s) due to(%s)', $acquisition->item()->name(), $acquired->getError()
                    )
                );
            }
        }

        return Result::success();
    }
}
