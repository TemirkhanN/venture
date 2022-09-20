<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Craft\RecipeRepository;
use TemirkhanN\Venture\Item\ItemRepositoryInterface;
use TemirkhanN\Venture\Player\Action\Craft;
use TemirkhanN\Venture\Player\Player;

class CraftItem implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'CraftItem';

    public function __construct(
        private readonly ItemRepositoryInterface $itemRepository,
        private readonly RecipeRepository $recipeRepository
    ) {

    }

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        if (!$player->isCrafting()) {
            return;
        }

        $recipeId = $action->getInput('recipeId', ActionInterface::TYPE_INT);
        $recipe = $this->recipeRepository->getById($recipeId);

        (new Craft($player, $this->itemRepository))->perform($recipe);
    }
}
