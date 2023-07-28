<?php

declare(strict_types=1);

namespace GameClient\UI\Scene;

use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Craft\RecipeRepository;
use GameClient\Component\Player\Player;
use GameClient\IO\InputInterface;
use GameClient\IO\OutputInterface;
use GameClient\Storage\PlayerRepository;
use GameClient\UI\Renderer\RendererInterface;
use GameClient\UI\SceneInterface;
use TemirkhanN\Venture\Item\Prototype\Resource;
use TemirkhanN\Venture\Player\Inventory\Slot;

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
        foreach ($player->player->showInventory() as $slot) {
            if (!$slot->isEmpty() && Resource::isResource($slot->item)) {
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
        foreach ($player->player->recipeBook() as $recipeId) {
            $recipes[] = $this->recipeRepository->getById((string) $recipeId);
        }

        return $recipes;
    }
}
