<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Character;
use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Craft\RecipeBook;
use TemirkhanN\Venture\Player\Inventory;
use TemirkhanN\Venture\Utils\Generic\ImmutableList;
use TemirkhanN\Venture\Utils\Id;

/**
 * @todo Rethink player states. They might not be needed in the domain
 */
class Player implements Character\CharacterInterface
{
    use Character\CharacterTrait;

    public PlayerState $state;

    private RecipeBook $recipeBook;

    public function __construct(string $name, Character\Stats $stats)
    {
        $this->instanceId = Id::generate('player');
        $this->id         = $this->instanceId;
        $this->state      = PlayerState::Idle;
        $this->name       = $name;
        $this->stats      = $stats;
        $this->equipment  = new Character\Equipment\Equipment();
        $this->inventory  = new Inventory\Inventory();
        $this->recipeBook = new RecipeBook();
    }

    /**
     * @return ImmutableList<Id>
     */
    public function recipeBook(): ImmutableList
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

    public function isInDungeon(): bool
    {
        return $this->state == PlayerState::InDungeon;
    }

    public function isInFight(): bool
    {
        return $this->state == PlayerState::Fighting;
    }

    public function isIdle(): bool
    {
        return $this->state == PlayerState::Idle;
    }

    public function isCrafting(): bool
    {
        return $this->state == PlayerState::Crafting;
    }
}
