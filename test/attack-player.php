<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Npc;

require_once __DIR__ .'/bootstrap.php';

/** @var Battle|null $battle */
$battle = getCache()->get('started-battle');
if ($battle === null) {
    fatalError('Battle is not created. Call according script first.');
}

if ($battle->isOver()) {
    fatalError('The battle is already over. Start new one.');
}

if ($battle->doesCurrentTurnBelongToPlayer()) {
    fatalError('Current turn does not belong to enemy.');
}

$battle->applyAction(new Npc\Action\AttackPlayer());

renderPlayer($battle->player());
renderBattle($battle);

getCache()->save('started-battle', $battle);
