<?php

declare(strict_types=1);

namespace GameClient\UI\Renderer\Extension;

use TemirkhanN\Venture\Character\Prototype\CharacterInterface;
use TemirkhanN\Venture\Npc\Npc;

class CharacterDetail
{
    private const GAME_DIR = ROOT_DIR . '/client/';

    public function getImagePath(CharacterInterface $character): string
    {
        if ($character instanceof Npc) {
            $path = sprintf('/assets/images/enemies/%s.png', strtolower($character->name()));

            if (!file_exists(self::GAME_DIR . $path)) {
                $path = '/assets/images/enemies/unknown-enemy.png';
            }

            return $path;
        }

        return '/assets/images/player/base.png';
    }
}
