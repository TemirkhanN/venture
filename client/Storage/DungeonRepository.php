<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use TemirkhanN\Venture\Dungeon\Dungeon;

class DungeonRepository extends AbstractObjectStorage
{
    private const CACHE_KEY = 'player_dungeon';


    public function find(): ?Dungeon
    {
        /** @var Dungeon|null $dungeon */
        $dungeon = $this->getObject(self::CACHE_KEY, Dungeon::class);

        return $dungeon;
    }

    public function save(Dungeon $dungeon): void
    {
        $this->saveObject(self::CACHE_KEY, $dungeon);
    }
}
