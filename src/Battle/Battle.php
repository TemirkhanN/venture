<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use SplStack;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;

class Battle
{
    private ?Player $player;

    private Npc $enemy;

    private int $turn = 0;

    private SplStack $logs;

    public function __construct(Npc $enemy)
    {
        $this->enemy = $enemy;
        $this->logs = new SplStack();
    }

    public function start(Player $with): void
    {
        if ($this->isStarted()) {
            throw new \DomainException('Battle has already started');
        }

        $this->player = $with;
    }

    public function applyAction(ActionInterface $action): void
    {
        $action->perform($this);
        if (!$this->isOver()) {
            $this->turn++;
        }
    }

    public function player(): ?Player
    {
        return $this->player;
    }

    public function enemy(): Npc
    {
        return $this->enemy;
    }

    public function doesCurrentTurnBelongToPlayer(): bool
    {
        if (!$this->isStarted()) {
            throw new \LogicException('Battle is not started yet');
        }

        return $this->turn % 2 === 1;
    }

    public function isStarted(): bool
    {
        return $this->turn > 0;
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
     */
    public function logs(): iterable
    {
        yield from $this->logs;
    }
}
