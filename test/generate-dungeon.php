<?php

declare(strict_types=1);

use TemirkhanN\Venture\Dungeon\DungeonGenerator;
use TemirkhanN\Venture\Dungeon\StageBuilder;
use TemirkhanN\Venture\Npc\NpcRepository;

require_once __DIR__ .'/bootstrap.php';

$dungeonGenerator = new DungeonGenerator(
    new StageBuilder(new NpcRepository())
);

$dungeon = $dungeonGenerator->generate(3, 4);

saveDataIntoMemory('new-dungeon', $dungeon);

renderDungeon($dungeon);