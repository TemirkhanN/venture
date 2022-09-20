<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character;
use TemirkhanN\Venture\Craft\Recipe;
use TemirkhanN\Venture\Craft\RecipeBook;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Item\Currency;
use TemirkhanN\Venture\Player\Inventory;
use TemirkhanN\Venture\Utils\Id;

class Player implements Battle\TargetInterface
{
    use Character\CharacterTrait;

    public PlayerState $state;

    private RecipeBook $recipeBook;

    public function __construct(string $name, Character\Stats $stats)
    {
        $this->state     = PlayerState::Idle;
        $this->name      = $name;
        $this->stats     = $stats;
        $this->equipment = new Character\Equipment\Equipment();
        $this->inventory = new Inventory\Inventory();
        $this->recipeBook = new RecipeBook();
    }

    public function gold(): int
    {
        foreach ($this->inventory->list() as $slot) {
            if ($slot->item->name() === Currency::CURRENCY_NAME_GOLD) {
                return $slot->amountOfItems;
            }
        }

        return 0;
    }

    /**
     * @param int $goldPrice
     * @param iterable<Drop> $drop
     *
     * @return void
     */
    public function buyItems(int $goldPrice, iterable $drop): void
    {
        if ($this->gold() < $goldPrice) {
            throw new \DomainException('Player does not have that enough gold to pay for items');
        }

        $this->inventory->removeGold($goldPrice);

        foreach ($drop as $loot) {
            $this->loot($loot);
        }
    }

    public function loot(Drop $drop)
    {
        $this->inventory->putItem($drop->item, $drop->amount);
    }

    public function discardItem(Inventory\Slot $slot): void
    {
        $this->inventory->removeItem($slot);
    }

    public function receiveReward(Battle\Battle $for): void
    {
        (new Action\Loot($this))->perform($for);
    }

    /**
     * @return iterable<Id>
     */
    public function recipeBook(): iterable
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
