<?php

declare(strict_types=1);

namespace GameClient\Action\Craft;

use TemirkhanN\Venture\Craft\RecipeRepository;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Component\Player\PlayerState;
use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;
use TemirkhanN\Venture\Player\Action\Craft;

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

        if ($player->state !== PlayerState::Crafting) {
            return;
        }

        $recipeId = $action->getInput('recipeId', ActionInterface::TYPE_STRING);
        $recipe = $this->recipeRepository->getById($recipeId);

        (new Craft($player->player, $this->itemRepository))->perform($recipe);
    }
}
