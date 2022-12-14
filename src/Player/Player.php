<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Generic\Collection\CollectionInterface;
use TemirkhanN\Venture\Character;
use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Craft\RecipeBook;
use TemirkhanN\Venture\Player\Inventory;
use TemirkhanN\Venture\Utils\Id;

class Player implements Character\CharacterInterface
{
    use Character\CharacterTrait;

    private RecipeBook $recipeBook;

    public function __construct(string $name, Character\Stats\Stats $stats)
    {
        $this->instanceId = Id::generate('player');
        $this->id         = $this->instanceId;
        $this->name       = $name;
        $this->stats      = $stats;
        $this->equipment  = new Character\Equipment\Equipment();
        $this->inventory  = new Inventory\Inventory();
        $this->recipeBook = new RecipeBook();
    }

    /**
     * @return CollectionInterface<Id>
     */
    public function recipeBook(): CollectionInterface
    {
        return $this->recipeBook->listRecipes();
    }

    public function knowsRecipe(Recipe $recipe): bool
    {
        return $this->recipeBook->containsRecipe($recipe);
    }

    public function learnRecipe(Recipe $recipe): void
    {
        $this->recipeBook->addRecipe($recipe);
    }

    public function gainExperience(int $amount): void
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not gain negative amount of experience');
        }

        $this->exp += $amount;
    }
}
