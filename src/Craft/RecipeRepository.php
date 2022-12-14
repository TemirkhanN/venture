<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

use TemirkhanN\Venture\Craft\Requirement\ItemRequirement;
use TemirkhanN\Venture\Utils\Db\Table;
use TemirkhanN\Venture\Utils\Id;

class RecipeRepository
{
    private readonly Table $tableGateway;

    public function __construct()
    {
        $this->tableGateway = new Table('recipes');
    }

    public function getById(string $id): Recipe
    {
        $data = $this->tableGateway->findById($id);
        if ($data === null) {
            throw new \RuntimeException('Recipe does not exist');
        }

        return $this->hydrateToObject($id, $data);
    }

    private function hydrateToObject(string $recipeId, array $rawData): Recipe
    {
        $requiredItems = [];
        foreach ($rawData['requiredItems'] as $requiredItem) {
            $id = new Id((string) $requiredItem['id']);
            $requiredItems[] = new ItemRequirement(new ItemId($id), $requiredItem['amount']);
        }

        return new Recipe(
            new Id($recipeId),
            $requiredItems,
            new CraftResult(
                new ItemId(new Id($rawData['result']['item'])),
                $rawData['result']['amount']
            )
        );
    }
}
