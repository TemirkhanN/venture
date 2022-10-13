<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Action;

use TemirkhanN\Generic\Result;
use TemirkhanN\Generic\ResultInterface;
use TemirkhanN\Venture\Craft\CraftResult;
use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Item\Prototype\ItemRepository;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Trade\Purchase\Offer;
use TemirkhanN\Venture\Trade\Purchase\Purchase;

class Craft
{
    public function __construct(private readonly Player $player, private readonly ItemRepository $itemRepository)
    {

    }

    /**
     * @param Recipe $recipe
     *
     * @return ResultInterface<CraftResult>
     */
    public function perform(Recipe $recipe): ResultInterface
    {
        if (!$this->player->knowsRecipe($recipe)) {
            return Result::error('Player can not use recipe that he does not know');
        }

        $craftingMaterials = new Offer();
        foreach ($recipe->requiredItems() as $requirement) {
            $requiredItem = $this->itemRepository->getById((string)$requirement->item()->id);
            $craftingMaterials->require($requiredItem, $requirement->amount());
        }

        $expectedResult = $recipe->result();
        $craftingResult = new Offer();
        $craftingResult->require(
            $this->itemRepository->getById((string)$expectedResult->item()->id), $expectedResult->amount()
        );

        $exchange = new Purchase($craftingMaterials, $craftingResult);
        if (!$exchange->isAffordable($this->player)) {
            return Result::error('Player does not have required items');
        }

        $result = $exchange->perform($this->player);
        if (!$result->isSuccessful()) {
            return Result::error(sprintf('Could not complete the crafting due to(%s)', $result->getError()));
        }

        return Result::success($recipe->result());
    }
}
