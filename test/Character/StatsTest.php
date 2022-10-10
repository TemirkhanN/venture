<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    public function testStats(): void
    {
        $attack = 12;
        $defence = 7;
        $maxHealth = 100;

        $stats = new Stats(
            $attack,
            $defence,
            $maxHealth
        );

        self::assertEquals($attack, $stats->attack(), 'Attack mismatch');
        self::assertEquals($defence, $stats->defence(), 'Defence mismatch');
        self::assertEquals($maxHealth, $stats->maxHealth(), 'Max health mismatch');
        self::assertEquals($maxHealth, $stats->currentHealth(), 'Current health has to be full');
    }

    /**
     * @testWith [0]
     *           [1]
     *           [5]
     */
    public function testLowestStats(int $multiplier): void
    {
        $lowestAttack = 1;
        $lowestDefence = 0;
        $lowestMaxHealth = 5;

        $stats = Stats::lowestStats($multiplier);

        self::assertEquals($lowestAttack * $multiplier, $stats->attack(), 'Attack mismatch');
        self::assertEquals($lowestDefence * $multiplier, $stats->defence(), 'Defence mismatch');
        self::assertEquals($lowestMaxHealth * $multiplier, $stats->maxHealth(), 'Max health mismatch');
        self::assertEquals($lowestMaxHealth * $multiplier, $stats->currentHealth(), 'Current health has to be full');
    }

    /**
     * @testWith [5, 3, 2]
     *           [4, 4, 0]
     *           [5, 10, -5]
     */
    public function testLoseHealth(int $maxHealth, int $losingAmount, int $expectedCurrentHealth): void
    {
        $stats = new Stats(0,0, $maxHealth);
        $stats->loseHealth($losingAmount);

        self::assertEquals($expectedCurrentHealth, $stats->currentHealth(), 'Current health mismatch');
    }

    /**
     * @testWith [6, 3, 2, 5]
     *           [4, 4, 1, 1]
     *           [10, 9, 9, 10]
     *           [10, 0, 10, 10]
     */
    public function testGainHealth(int $maxHealth, int $losingAmount, int $restoringAmount, int $expectedCurrentHealth): void
    {
        $stats = new Stats(0,0, $maxHealth);
        $stats->loseHealth($losingAmount);
        $stats->restoreHealth($restoringAmount);

        self::assertEquals($expectedCurrentHealth, $stats->currentHealth(), 'Current health mismatch');
    }
}
