<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Venture\Craft\Requirement\ItemRequirement;
use TemirkhanN\Venture\Utils\Id;

class Recipe
{
    /**
     * @param \TemirkhanN\Venture\Utils\Id $id
     * @param array<ItemRequirement> $requiredItems
     * @param CraftResult $result
     */
    public function __construct(
        private readonly Id $id,
        private readonly array $requiredItems,
        private readonly CraftResult $result
    ) {
    }

    public function id(): Id
    {
        return $this->id;
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
