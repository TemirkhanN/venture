<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Scene;

use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Craft\RecipeRepository;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Item\Resource;
use TemirkhanN\Venture\Player\Inventory\Slot;
use TemirkhanN\Venture\Player\Player;

class Craft implements SceneInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly RecipeRepository $recipeRepository,
        private readonly RendererInterface $renderer
    )
    {

    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $player = $this->playerRepository->find();
        if ($player === null) {
            return;
        }

        $output->write($this->renderer->render('craft/main', [
            'resources' => $this->getPlayerResources($player),
            'recipes'   => $this->getPlayerRecipes($player),
            'title' => 'Craft system',
        ]));
    }

    /**
     * @param Player $player
     *
     * @return iterable<Slot>
     */
    private function getPlayerResources(Player $player): iterable
    {
        foreach ($player->showInventory() as $slot) {
            if (Resource::isResource($slot->item)) {
                yield $slot;
            }
        }
    }

    /**
     * @param Player $player
     *
     * @return iterable<Recipe>
     */
    private function getPlayerRecipes(Player $player): iterable
    {
        $recipes = [];
        foreach ($player->recipeBook() as $recipeId) {
            $recipes[] = $this->recipeRepository->getById($recipeId->value());
        }

        return $recipes;
    }
}
