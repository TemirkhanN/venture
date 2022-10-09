<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Venture\Utils\Generic\ImmutableList;
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
     * @return ImmutableList<Id>
     */
    public function listRecipes(): ImmutableList
    {
        return new ImmutableList($this->recipeIds);
    }

    public function containsRecipe(Recipe $recipe): bool
    {
        return isset($this->recipeIds[$recipe->id()->value()]);
    }
}
