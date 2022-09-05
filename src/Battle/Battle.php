<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use SplStack;
use TemirkhanN\Venture\Npc\Drop;
use TemirkhanN\Venture\Npc\GenerateDrop;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;

class Battle
{
    private ?Player $player = null;

    private Npc $enemy;

    private int $turn = 0;

    private SplStack $logs;

    private bool $rewardsIssued = false;

    public function __construct(Npc $enemy)
    {
        $this->enemy = $enemy;
        $this->logs = new SplStack();
    }

    public function start(Player $with): void
    {
        if ($this->isStarted() || $this->isOver()) {
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
        if (!$this->isStarted()) {
            return false;
        }

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

    /**
     * @return iterable<Drop>
     */
    public function issueRewards(): iterable
    {
        $rewards = [];
        if (!$this->rewardsIssued) {
            $rewards = (new GenerateDrop())->execute($this->enemy);
        }

        $this->rewardsIssued = true;

        return $rewards;
    }
}
