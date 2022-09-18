<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Item\Currency;
use TemirkhanN\Venture\Player\Inventory;

class Player implements Battle\TargetInterface
{
    use Character\CharacterTrait;

    public PlayerState $state;

    public function __construct(string $name, Character\Stats $stats)
    {
        $this->state     = PlayerState::Idle;
        $this->name      = $name;
        $this->stats     = $stats;
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

    /**
     * @param int $goldPrice
     * @param iterable<Drop> $drop
     *
     * @return void
     */
    public function buyItems(int $goldPrice, iterable $drop): void
    {
        if ($this->gold() < $goldPrice) {
            throw new \DomainException('Player does not have that enough gold to pay for items');
        }

        $this->inventory->removeItem(new Inventory\Slot(1, Currency::gold(), $goldPrice));

        foreach ($drop as $loot) {
            $this->loot($loot);
        }
    }

    public function loot(Drop $drop)
    {
        $this->inventory->putItem($drop->item, $drop->amount);
    }

    public function discardItem(Inventory\Slot $slot): void
    {
        $this->inventory->removeItem($slot);
    }

    public function receiveReward(Battle\Battle $for): void
    {
        (new Action\Loot($this))->perform($for);
    }

    public function isInDungeon(): bool
    {
        return $this->state == PlayerState::InDungeon;
    }

    public function isInFight(): bool
    {
        return $this->state == PlayerState::InFight;
    }

    public function isIdle(): bool
    {
        return $this->state == PlayerState::Idle;
    }
}
