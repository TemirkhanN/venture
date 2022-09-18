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

    public function getById(int $id): Recipe
    {
        $data = $this->tableGateway->findById($id);
        if ($data === null) {
            throw new \RuntimeException('Recipe does not exist');
        }

        return $this->hydrateToObject($data);
    }

    private function hydrateToObject(array $rawData): Recipe
    {
        $requiredItems = [];
        foreach ($rawData['requiredItems'] as $requiredItem) {
            $id = new Id($requiredItem['id']);
            $requiredItems[] = new ItemRequirement(new ItemId($id), $requiredItem['amount']);
        }

        return new Recipe(
            $requiredItems,
            new CraftResult(
                new ItemId(new Id($rawData['result']['item'])),
                $rawData['result']['amount']
            )
        );
    }
}
