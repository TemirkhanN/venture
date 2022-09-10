<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;

require_once __DIR__ .'/bootstrap.php';

/** @var Battle|null $battle */
$battle = getCache()->get('started-battle');
if ($battle === null) {
    fatalError('Battle is not created. Call according script first.');
}

$player = $battle->player();
if (!$battle->isStarted() || $player === null) {
    fatalError('Battle is not yet started');
}

if (!$battle->isOver()) {
    fatalError('Battle is not over yet to receive rewards.');
}

if (!$battle->player()->isAlive()) {
    fatalError('Player has to win the battle/be alive in order to receive the rewards');
}

$player->receiveReward($battle);

renderPlayer($player);
renderInventory($player);
