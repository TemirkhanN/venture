<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use TemirkhanN\Venture\Battle\Battle;

class BattleRepository extends AbstractObjectStorage
{
    private const CACHE_KEY = 'player_battle';

    public function find(): ?Battle
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
