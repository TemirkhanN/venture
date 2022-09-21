<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Renderer\Extension;

use TemirkhanN\Venture\Character\CharacterInterface;
use TemirkhanN\Venture\Npc\Npc;

class CharacterDetail
{
    private const GAME_DIR = ROOT_DIR . '/client/';

    public function getImagePath(CharacterInterface $character): string
    {
        if ($character instanceof Npc) {
            $path = sprintf('/assets/enemies/%s.png', strtolower($character->name()));

            if (!file_exists(self::GAME_DIR . $path)) {
                $path = '/assets/enemies/unknown-enemy.png';
            }

            return $path;
        }

        return '/assets/player/base.png';
    }
}
