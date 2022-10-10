<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Battle;

use PHPUnit\Framework\TestCase;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Id;

class BattleTest extends TestCase
{
    private Player $player;
    private Npc $enemy;

    private Battle $battle;

    public function setUp(): void
    {
        parent::setUp();

        $this->player = new Player('Walrog', Stats::lowestStats(2));
        $this->enemy  = new Npc(Id::generate('testNpc'), 'Slime', Stats::lowestStats());

        $this->battle = new Battle($this->player, $this->enemy);
    }

    public function testEnemy(): void
    {
        self::assertSame($this->enemy, $this->battle->enemy());
    }

    public function testPlayer(): void
    {
        self::assertSame($this->player, $this->battle->player());
    }

    public function testDoesCurrentTurnBelongToPlayer(): void
    {
        self::assertTrue($this->battle->doesCurrentTurnBelongToPlayer(), 'Initial turn does not belong to the player');
    }

    public function testDoesCurrentTurnBelongToEnemy(): void
    {
        $anyAction = $this->createMock(ActionInterface::class);
        $this->battle->applyAction($anyAction);
        self::assertFalse($this->battle->doesCurrentTurnBelongToPlayer(), 'Current turn had to pass to the enemy');
    }

    public function testIsOverIfPlayerIsDead(): void
    {
        self::assertFalse($this->battle->isOver(), 'Battle shall not be yet over');

        $this->player->loseHp(10000);

        self::assertTrue($this->battle->isOver(), 'Battle had to end');
    }

    public function testIsOverIfEnemyIsDead(): void
    {
        self::assertFalse($this->battle->isOver(), 'Battle shall not be yet over');

        $this->enemy->loseHp(10000);

        self::assertTrue($this->battle->isOver(), 'Battle had to end');
    }

    public function testPerformAction(): void
    {
        $action = $this->createMock(ActionInterface::class);
        $action
            ->expects(self::once())
            ->method('perform')
            ->with(self::identicalTo($this->battle));

        $this->battle->applyAction($action);
    }
}
