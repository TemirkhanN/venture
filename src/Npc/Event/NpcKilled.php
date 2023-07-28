<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc\Event;

use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;

readonly class NpcKilled
{
    // @todo add perk subscriber(10 NPC killed - additional attack bonus with that NPC type)
    public function __construct(public Npc $npc, public Player $killer) {}
}
