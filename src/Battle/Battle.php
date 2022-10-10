<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use SplStack;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Player\PlayerState;

class Battle
{
    private int $turn = 0;
    private SplStack $logs;

    public function __construct(private readonly Player $player, private readonly Npc $enemy)
    {
        if ($player->state === PlayerState::Fighting) {
            throw new \DomainException('Player is already fighting');
        }
        $this->player->state = PlayerState::Fighting;

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
}
