<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Item\Currency;
use TemirkhanN\Venture\Player\Inventory\Slot;

class Player implements Battle\TargetInterface
{
    use Character\CharacterTrait;

    private Character\Stats $stats;
    private Inventory\Inventory $inventory;

    public PlayerState $state;

    public function __construct(string $name, Character\Stats $stats)
    {
        $this->state = PlayerState::Idle;
        $this->name = $name;
        $this->stats = $stats;
        $this->equipment = new Character\Equipment\Equipment();
        $this->inventory = new Inventory\Inventory();
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

    public function isInDungeon(): bool
    {
        return $this->state == PlayerState::InDungeon;
    }

    public function isInFight(): bool
    {
        return $this->state == PlayerState::InFight;
    }
}
