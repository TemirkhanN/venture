<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Player\Player;

class BattleRepository extends AbstractObjectStorage
{
    private const CACHE_KEY = 'player_battle';

    public function findByPlayer(Player $player): ?Battle
    {
        /** @var Battle|null $battle */
        $battle = $this->getObject(self::CACHE_KEY, Battle::class);

        return $battle;
    }

    public function save(Battle $battle): void
    {
        $this->saveObject(self::CACHE_KEY, $battle);
    }
}
