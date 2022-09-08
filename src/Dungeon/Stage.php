<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Dungeon;

use TemirkhanN\Venture\Npc\Npc;

class Stage
{
    private readonly string $name;

    /**
     * @var Npc[]
     */
    private readonly array $monsters;

    /**
     * @param Npc[] $monsters
     */
    public function __construct(string $name, array $monsters)
    {
        $this->name = $name;
        $this->monsters = $monsters;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return iterable<Npc>
     */
    public function monsters(): iterable
    {
        yield from $this->monsters;
    }

    public function isComplete(): bool
    {
        foreach ($this->monsters as $monster) {
            if ($monster->isAlive()) {
                return false;
            }
        }

        return true;
    }
}
