<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

use TemirkhanN\Venture\Item\Effect\Effect;
use TemirkhanN\Venture\Item\Effect\EffectType;
use TemirkhanN\Venture\Utils\Db\Table;
use TemirkhanN\Venture\Utils\Id;

class ItemRepository implements ItemRepositoryInterface
{
    private Table $tableGateway;
    private Table $effectTableGateway;

    public function __construct()
    {
        $this->tableGateway = new Table('items');
        // TODO likely should have own domain for effects are only aggregated in some items
        $this->effectTableGateway = new Table('effects');
    }

    public function findById(string $id): ?ItemInterface
    {
        $data = $this->tableGateway->findById($id);
        if ($data === null) {
            return null;
        }

        return $this->hydrateToObject($id, $data);
    }

    public function getById(string $id): ItemInterface
    {
        $item = $this->findById($id);
        if ($item === null) {
            throw new \RuntimeException(sprintf('Item with id %d does not exist', $id));
        }

        return $item;
    }

    private function hydrateToObject(string $rawId, array $itemData): ItemInterface
    {
        $id = new Id($rawId);
        switch ($itemData['type']) {
            case Armor::ITEM_TYPE:
                return new Armor($id, $itemData['name'], $itemData['defence'], $itemData['health']);
            case Weapon::ITEM_TYPE:
                return new Weapon($id, $itemData['name'], $itemData['attack']);
            case Currency::ITEM_TYPE:
                return new Currency($id, $itemData['name']);
            case Consumable::ITEM_TYPE:
                $effects = [];
                foreach ($itemData['effects'] as $effectDetails) {
                    $effectData = $this->effectTableGateway->findById((string) $effectDetails['id']);
                    $effects[] = new Effect(
                        $effectData['name'],
                        EffectType::from($effectData['type']),
                        $effectData['description'],
                        $effectDetails['power']
                    );
                }

                return new Consumable($id, $itemData['name'], $effects);
            case Resource::ITEM_TYPE:
                return new Resource($id, $itemData['name']);
            default:
                throw new \UnexpectedValueException(sprintf('Unknown type %s', $itemData['type']));
        }
    }
}
