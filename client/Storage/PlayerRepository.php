<?php

declare(strict_types=1);

namespace GameClient\Storage;

use GameClient\Component\Player\Player;

class PlayerRepository extends AbstractObjectStorage
{
    private const CACHE_KEY = 'player';

    public function find(): ?Player
    {
        /** @var Player|null $player */
        $player = $this->getObject(self::CACHE_KEY, Player::class);

        return $player;
    }

    public function save(Player $player): void
    {
        $this->saveObject(self::CACHE_KEY, $player);
    }
}
