<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Venture\Utils\Db\Id;

class RecipeBook
{
    private array $recipeIds = [];

    public function addRecipe(Recipe $recipe): void
    {
        if ($this->containsRecipe($recipe)) {
            return;
        }

        $this->recipeIds[$recipe->id()->value()] = $recipe->id();
    }

    /**
     * @return iterable<\TemirkhanN\Venture\Utils\Db\Id>
     */
    public function listRecipes(): iterable
    {
        yield from $this->recipeIds;
    }

    public function containsRecipe(Recipe $recipe): bool
    {
        return isset($this->recipeIds[$recipe->id()->value()]);
    }
}
