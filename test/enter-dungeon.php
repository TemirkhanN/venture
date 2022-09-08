<?php

declare(strict_types=1);

use TemirkhanN\Venture\Dungeon\Dungeon;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';

/** @var Player|null $player */
$player = getDataFromMemory('equipped-player');

if ($player === null) {
    fatalError('Player is not created/equipped. Call according script firsts.');
}

/** @var Dungeon|null $dungeon */
$dungeon = getDataFromMemory('new-dungeon');

if ($dungeon === null) {
    fatalError('Dungeon is not generated. Call according script first.');
}

$dungeon->enter($player);

saveDataIntoMemory('active-dungeon', $dungeon);

renderDungeon($dungeon);
