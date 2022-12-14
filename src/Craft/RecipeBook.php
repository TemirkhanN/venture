<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Generic\Collection\Collection;
use TemirkhanN\Generic\Collection\CollectionInterface;
use TemirkhanN\Venture\Utils\Id;

class RecipeBook
{
    private array $recipeIds = [];

    public function addRecipe(Recipe $recipe): void
    {
        if ($this->containsRecipe($recipe)) {
            return;
        }

        $this->recipeIds[(string) $recipe->id()] = $recipe->id();
    }

    /**
     * @return CollectionInterface<Id>
     */
    public function listRecipes(): CollectionInterface
    {
        return new Collection($this->recipeIds);
    }

    public function containsRecipe(Recipe $recipe): bool
    {
        return isset($this->recipeIds[$recipe->id()->value()]);
    }
}
