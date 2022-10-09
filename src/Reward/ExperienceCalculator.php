<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Reward;

use TemirkhanN\Venture\Character\CharacterInterface;

class ExperienceCalculator
{
    public function calculate(CharacterInterface $attacker, CharacterInterface $victim): int
    {
        $stats = $victim->stats();
        $exp = (int)(($stats->attack() + $stats->defence() + $stats->maxHealth()) / 3);

        if ($exp === 0) {
            $exp = 1;
        }

        if ($exp < 5) {
            return $exp;
        }

        return $this->applyPenalty($exp, $attacker, $victim);
    }

    private function applyPenalty(int $experience, CharacterInterface $attacker, CharacterInterface $victim): int
    {
        $levelDifference = $attacker->lvl() - $victim->lvl();

        if ($levelDifference > 10) {
            return 0;
        }

        if ($levelDifference > 5) {
            return (int)($experience / 4);
        }

        if ($levelDifference > 3) {
            return (int)($experience / 2);
        }

        return $experience;
    }
}
