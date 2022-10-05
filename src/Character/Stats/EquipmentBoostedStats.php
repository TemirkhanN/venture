<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Stats;

use TemirkhanN\Venture\Character\Equipment;
use TemirkhanN\Venture\Character\StatsInterface;

class EquipmentBoostedStats extends AbstractBoostedStats implements StatsInterface
{
    public function __construct(Equipment\Equipment $equipment, StatsInterface $baseStats)
    {
        parent::__construct($baseStats);

        $bonusAttack  = 0;
        $bonusDefence = 0;
        $bonusHealth  = 0;
        foreach ($equipment->list() as $item) {
            $bonusAttack  += $item->attack;
            $bonusDefence += $item->defence;
            $bonusHealth  += $item->health;
        }

        $this->bonusAttack  = $bonusAttack;
        $this->bonusDefence = $bonusDefence;
        $this->bonusHealth  = $bonusHealth;
    }
}
