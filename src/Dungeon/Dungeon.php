<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Dungeon;

use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;

class Dungeon
{
    /**
     * @var array<Stage>
     */
    private readonly array $stages;

    private ?Player $player = null;

    public function __construct(array $stages)
    {
        if ($stages === []) {
            throw new \LogicException('Dungeon shall have at least one floor');
        }

        $this->stages = array_values($stages);
    }

    public function enter(Player $player): void
    {
        if ($this->player !== null) {
            throw new \LogicException('This dungeon was already visited by player');
        }

        if ($player->isInDungeon()) {
            throw new \LogicException('Player is already in another dungeon');
        }

        $this->player = $player;
        $this->player->state = PlayerState::InDungeon;
    }

    public function player(): ?Player
    {
        return $this->player;
    }

    public function currentStage(): ?Stage
    {
        if ($this->player === null) {
            return null;
        }

        foreach ($this->stages as $stage) {
            if (!$stage->isComplete()) {
                return $stage;
            }
        }

        return null;
    }

    /**
     * @return iterable<Stage>
     */
    public function stages(): iterable
    {
        yield from $this->stages;
    }
}
