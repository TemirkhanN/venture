<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use TemirkhanN\Venture\Dungeon\Dungeon;
use TemirkhanN\Venture\Player\Player;

class DungeonRepository extends AbstractObjectStorage
{
    private const CACHE_KEY = 'player_dungeon';

    public function find(Player $player): ?Dungeon
    {
        /** @var Dungeon|null $dungeon */
        $dungeon = $this->getObject(self::CACHE_KEY, Dungeon::class);

        if ($dungeon !== null && $dungeon->player() !== null) {
            (new \ReflectionProperty($dungeon, 'player'))->setValue($dungeon, $player);
        }

        return $dungeon;
    }

    public function save(Dungeon $dungeon): void
    {
        $this->saveObject(self::CACHE_KEY, $dungeon);
    }

    public function close(Dungeon $dungeon): void
    {
        $this->deleteObject($dungeon);
    }
}
