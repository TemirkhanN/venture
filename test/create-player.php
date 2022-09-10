<?php

declare(strict_types=1);

use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';

$player = new Player('Wilheim', new Stats(2, 0, 5));

renderPlayer($player);

getCache()->save('new-player', $player);
