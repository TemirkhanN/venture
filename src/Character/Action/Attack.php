<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Action;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Utils\Generic\Result;

class Attack implements Battle\ActionInterface
{
    public function perform(Battle\Battle $at): Result
    {
        if ($at->isOver()) {
            return Result::error('Can not perform actions in inactive battle.');
        }

        $attackerIsPlayer = $at->doesCurrentTurnBelongToPlayer();
        if ($attackerIsPlayer) {
            $attacker = $at->player();
            $target   = $at->enemy();
        } else {
            $attacker = $at->enemy();
            $target   = $at->player();
        }

        if (!$attacker->isAlive() || !$target->isAlive()) {
            return Result::error('The battle should be already over');
        }

        $damage = $attacker->stats()->attack() - $target->stats()->defence();
        if ($damage < 0) {
            $damage = 0;
        }
        $target->loseHp($damage);

        $at->addLog(sprintf('%s dealt %d damage to %s', $attacker->name(), $damage, $target->name()));

        if (!$target->isAlive()) {
            $at->addLog($attackerIsPlayer ? 'Victory!' : 'Defeat!');
        }

        return Result::success($damage);
    }
}
