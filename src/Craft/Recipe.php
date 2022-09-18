<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Venture\Craft\Requirement\ItemRequirement;

class Recipe
{
    /**
     * @param array<ItemRequirement> $requiredItems
     * @param CraftResult $result
     */
    public function __construct(private readonly array $requiredItems, private readonly CraftResult $result)
    {
    }

    /**
     * @return iterable<ItemRequirement>
     */
    public function requiredItems(): iterable
    {
        return $this->requiredItems;
    }

    public function result(): CraftResult
    {
        return $this->result;
    }
}
