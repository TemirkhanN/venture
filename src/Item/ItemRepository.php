<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

use Symfony\Component\Yaml\Yaml;

class ItemRepository implements ItemRepositoryInterface
{
    /**
     * @var array<ItemInterface>
     */
    private array $items = [];

    public function __construct()
    {
        $this->loadItems(RESOURCE_DIR . '/items/armors.yaml');
        $this->loadItems(RESOURCE_DIR . '/items/weapons.yaml');
    }

    public function findById(int $id): ?ItemInterface
    {
        return $this->items[$id] ?? null;
    }

    public function getById(int $id): ItemInterface
    {
        $item = $this->findById($id);
        if ($item === null) {
            throw new \RuntimeException(sprintf('Item with id %d does not exist', $id));
        }

        return $item;
    }

    private function loadItems(string $fromFile): void
    {
        foreach (Yaml::parseFile($fromFile) as $itemId => $itemData) {
            if (isset($this->items[$itemId])) {
                throw new \UnexpectedValueException('Multiple items with the same id.');
            }

            switch ($itemData['type']) {
                case Armor::ITEM_TYPE:
                    $item = new Armor($itemData['name'], $itemData['defence'], $itemData['health']);
                    break;
                case Weapon::ITEM_TYPE:
                    $item = new Weapon($itemData['name'], $itemData['attack']);
                    break;
                default:
                    throw new \UnexpectedValueException(sprintf('Unknown type %s', $itemData['type']));
            }

            $this->items[$itemId] = $item;
        }
    }
}
