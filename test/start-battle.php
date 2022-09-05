<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Action\EngageBattle;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';

/** @var Player|null $player */
$player = getDataFromMemory('equipped-player');

if ($player === null) {
    fatalError('Player is not created. Call according script first.');
}

$enemy = new Npc('Morlok', Stats::lowestStats());

$battle = new Battle($enemy);
$battle->applyAction(new EngageBattle($player));

renderPlayer($battle->player());
renderBattle($battle);

saveDataIntoMemory('started-battle', $battle);
