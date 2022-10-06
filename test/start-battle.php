<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Npc\NpcRepository;
use TemirkhanN\Venture\Player\Action\EngageBattle;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';

/** @var Player|null $player */
$player = getCache()->get('equipped-player');

if ($player === null) {
    fatalError('Player is not created. Call according script first.');
}

$npcRepository = new NpcRepository();
$enemy = $npcRepository->getById('1');

$battle = new Battle($enemy);
$battle->applyAction(new EngageBattle($player));

renderPlayer($battle->player());
renderBattle($battle);

getCache()->save('started-battle', $battle);
