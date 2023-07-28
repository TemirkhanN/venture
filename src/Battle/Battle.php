<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use SplStack;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;

class Battle
{
    private int $turn;
    private SplStack $logs;

    // @todo player has to be readonly but currently reflection is used to sync objects with each other
    public function __construct(private Player $player, private readonly Npc $enemy)
    {
        $this->turn = 1;

        $this->logs = new SplStack();
        $this->addLog(sprintf('%s started battle with %s', $player->name(), $enemy->name()));
    }

    public function applyAction(ActionInterface $action): void
    {
        $action->perform($this);
        if (!$this->isOver()) {
            $this->turn++;
        }
    }

    public function player(): Player
    {
        return $this->player;
    }

    public function enemy(): Npc
    {
        return $this->enemy;
    }

    public function doesCurrentTurnBelongToPlayer(): bool
    {
        if (!$this->player->isAlive()) {
            return false;
        }

        return $this->turn % 2 === 1;
    }

    public function isOver(): bool
    {
        return !$this->player->isAlive() || !$this->enemy->isAlive();
    }

    public function addLog(string $log): void
    {
        $this->logs->push($log);
    }

    /**
     * @return iterable<string>
     *
     * @usedBy twig template
     *
     * @todo move to observer driven
     */
    public function logs(): iterable
    {
        yield from $this->logs;
    }
}
