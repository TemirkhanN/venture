<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Player\Inventory\Slot;

class Player implements Battle\TargetInterface
{
    use Character\CharacterTrait;

    private Character\Stats $stats;
    private Inventory\Inventory $inventory;

    public function __construct(string $name, Character\Stats $stats)
    {
        $this->name = $name;
        $this->stats = $stats;
        $this->equipment = new Character\Equipment\Equipment();
        $this->inventory = new Inventory\Inventory();
    }

    public function loot(Drop $drop)
    {
        $this->inventory->putItem($drop->item, $drop->amount);
    }

    public function receiveReward(Battle\Battle $for): void
    {
        (new Action\Loot($this))->perform($for);
    }

    /**
     * @return iterable<Slot>
     */
    public function showInventory(): iterable
    {
        return $this->inventory->list();
    }
}
