<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Action;

use TemirkhanN\Venture\Craft\CraftResult;
use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Item\ItemRepository;
use TemirkhanN\Venture\Player\Inventory\Slot;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Generic\Result;

class Craft
{
    public function __construct(private readonly Player $player, private readonly ItemRepository $itemRepository)
    {

    }

    /**
     * @param Recipe $recipe
     *
     * @return Result<CraftResult>
     */
    public function perform(Recipe $recipe): Result
    {
        $requirements = [];
        foreach ($recipe->requiredItems() as $requirement) {
            $itemId = $requirement->item()->id->value();
            if (!isset($requirements[$itemId])) {
                $requirements[$itemId] = 0;
            }

            $requirements[$itemId] += $requirement->amount();
        }


        if ($requirements === []) {
            $this->gatherCraftResult($recipe->result());

            return Result::success($recipe->result());
        }

        $itemsToBeUsed = [];
        foreach ($this->player->showInventory() as $slot) {
            if ($requirements === []) {
                break;
            }

            $itemId = $slot->item->id()->value();
            if (!isset($requirements[$itemId])) {
                continue;
            }

            $requiredAmount = $requirements[$itemId];
            if ($requiredAmount <= $slot->amountOfItems) {
                $discardingAmount = $requiredAmount;
                // requirement is fulfilled
                unset($requirements[$itemId]);
            } else {
                $discardingAmount = $slot->amountOfItems;
                $requirements[$itemId] -= $slot->amountOfItems;
            }
            $itemsToBeUsed[] = new Slot($slot->position, $slot->item, $discardingAmount);
        }

        if ($requirements !== []) {
            return Result::error('Player does not have required items');
        }

        foreach ($itemsToBeUsed as $slot) {
            $this->player->discardItem($slot);
        }

        $this->gatherCraftResult($recipe->result());

        return Result::success($recipe->result());
    }

    private function gatherCraftResult(CraftResult $result): void
    {
        $craftedItem = $this->itemRepository->getById($result->item()->id->value());

        $this->player->loot(new Drop($craftedItem, $result->amount()));
    }
}
