<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Player;

require_once __DIR__ .'/bootstrap.php';

/** @var Battle|null $battle */
$battle = getDataFromMemory('started-battle');
if ($battle === null) {
    fatalError('Battle is not created. Call according script first.');
}

if ($battle->isOver()) {
    fatalError('The battle is already over. Start new one.');
}

if (!$battle->doesCurrentTurnBelongToPlayer()) {
    fatalError('Current turn does not belong to player.');
}

$battle->applyAction(new Player\Action\Attack());

renderPlayer($battle->player());
renderBattle($battle);

saveDataIntoMemory('started-battle', $battle);
