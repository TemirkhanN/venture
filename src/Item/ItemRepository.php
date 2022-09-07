<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use TemirkhanN\Venture\Utils\Db\Table;

class ItemRepository implements ItemRepositoryInterface
{
    private Table $tableGateway;

    public function __construct()
    {
        $this->tableGateway = new Table('items');
    }

    public function findById(int $id): ?ItemInterface
    {
        $data = $this->tableGateway->findById($id);
        if ($data === null) {
            return null;
        }

        return $this->hydrateToObject($data);
    }

    public function getById(int $id): ItemInterface
    {
        $item = $this->findById($id);
        if ($item === null) {
            throw new \RuntimeException(sprintf('Item with id %d does not exist', $id));
        }

        return $item;
    }

    private function hydrateToObject(array $itemData): ItemInterface
    {
        switch ($itemData['type']) {
            case Armor::ITEM_TYPE:
                return new Armor($itemData['name'], $itemData['defence'], $itemData['health']);
            case Weapon::ITEM_TYPE:
                return new Weapon($itemData['name'], $itemData['attack']);
            case Currency::ITEM_TYPE:
                return new Currency($itemData['name']);
            default:
                throw new \UnexpectedValueException(sprintf('Unknown type %s', $itemData['type']));
        }
    }
}
