<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Stats;

class LevelBoostedStats extends AbstractBoostedStats
{
    public function __construct(int $lvl, Stats $baseStats)
    {
        parent::__construct($baseStats);

        if ($lvl < 1) {
            throw new \DomainException('Level can not be lesser than 1');
        }

        $bonusAttack  = 0;
        $bonusDefence = 0;
        $bonusHealth  = 0;

        if ($lvl !== 1) {
            $bonusAttack  = (int)ceil($lvl / 3);
            $bonusDefence = (int)ceil($lvl / 3);
            $bonusHealth  = (int)round($lvl * 1.5);
            if ($baseStats->currentHealth() === 0) {
                $bonusHealth = 0;
            }
        }

        $this->bonusAttack  = $bonusAttack;
        $this->bonusDefence = $bonusDefence;
        $this->bonusHealth = $bonusHealth;
    }
}
