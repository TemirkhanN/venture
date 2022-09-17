<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc\Action;

use TemirkhanN\Venture\Battle;

class AttackPlayer implements Battle\ActionInterface
{
    public function perform(Battle\Battle $at): void
    {
        if (!$at->isStarted()) {
            throw new \DomainException('Can not perform actions in inactive battle.');
        }

        if ($at->doesCurrentTurnBelongToPlayer()) {
            throw new \DomainException('Current turn belongs to player.');
        }

        $attacker = $at->enemy();
        $target = $at->player();

        if (!$attacker->isAlive() || !$target->isAlive()) {
            throw new \DomainException('The battle should be already over');
        }

        $damage = $attacker->stats()->attack() - $target->stats()->defence();
        if ($damage < 0) {
            $damage = 0;
        }
        $target->decreaseHealth($damage);

        $at->addLog(sprintf('%s dealt %d damage to %s', $attacker->name(), $damage, $target->name()));

        if (!$target->isAlive()) {
            $at->addLog('Player lost.');
        }
    }
}
