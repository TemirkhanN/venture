<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc;

use TemirkhanN\Venture\Item\Armor;
use TemirkhanN\Venture\Item\Gold;
use TemirkhanN\Venture\Item\ItemInterface;
use TemirkhanN\Venture\Item\Weapon;

class GenerateDrop
{
    // TODO some reliable and configurable source of drop list
    private static $dropList = [
        'morlok' => [
            [
                'item' => [
                    'name' => 'Dagger',
                    'attack' => 1,
                    'defence' => 0,
                    'hp' => 0,
                    'type' => Weapon::class,
                ],
                'amount' => 1,
            ],
            [
                'item' => [
                    'name' => 'Gold',
                    'type' => Gold::class,
                ],
                'amount' => 100,
            ],
        ],
    ];

    /**
     * @param Npc $npc
     *
     * @return iterable<Drop>
     */
    public function execute(Npc $npc): iterable
    {
        $drops = self::$dropList[strtolower($npc->name())] ?? [];

        foreach ($drops as $dropDetails) {
            yield new Drop($this->generateItem($dropDetails['item']), $dropDetails['amount']);
        }
    }

    /**
     * @param array{name:string, type:class-string, attack: int, defence: int, hp: int} $rawData
     *
     * @return ItemInterface
     */
    private function generateItem(array $rawData): ItemInterface
    {
        switch ($rawData['type']) {
            case Weapon::class:
                return new Weapon($rawData['name'], $rawData['attack']);
            case Armor::class:
                return new Armor($rawData['name'], $rawData['defence'], $rawData['hp']);
            case Gold::class:
                return new Gold();
            default:
                throw new \UnexpectedValueException(sprintf('type %s is an unknown item', $rawData['type']));
        }
    }
}
