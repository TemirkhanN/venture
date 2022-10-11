<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Stats;

use PHPUnit\Framework\TestCase;
use TemirkhanN\Venture\Character\Equipment\Equipment;
use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Item\Armor;
use TemirkhanN\Venture\Item\Prototype\Armor as ArmorPrototype;
use TemirkhanN\Venture\Utils\Id;

class EquipmentBoostedStatsTest extends TestCase
{
    public function testStatsWithoutEquipment(): void
    {
        $attack = 3;
        $defence = 4;
        $maxHealth = 5;
        $baseStats = new Stats($attack, $defence, $maxHealth);
        $equipment = new Equipment();
        $stats = new EquipmentBoostedStats($equipment, $baseStats);

        self::assertEquals($attack, $stats->attack(), 'Attack mismatch');
        self::assertEquals($defence, $stats->defence(), 'Defence mismatch');
        self::assertEquals($maxHealth, $stats->maxHealth(), 'Max health mismatch');
        self::assertEquals($maxHealth, $stats->currentHealth(), 'Current health mismatch');
    }

    public function testStatsWithEquipment(): void
    {
        $attack = 3;
        $defence = 4;
        $maxHealth = 5;
        $equipment = new Equipment();
        $armorDefence = 2;
        $armorHealth = 4;
        $equipment->equip($this->createArmor($armorDefence, $armorHealth, 'Leather chest plate'));
        $baseStats = new Stats($attack, $defence, $maxHealth);
        $stats = new EquipmentBoostedStats($equipment, $baseStats);

        self::assertEquals($attack, $stats->attack(), 'Attack mismatch');
        self::assertEquals($defence + $armorDefence, $stats->defence(), 'Defence mismatch');
        self::assertEquals($maxHealth + $armorHealth, $stats->maxHealth(), 'Max health mismatch');
        self::assertEquals($maxHealth + $armorHealth, $stats->currentHealth(), 'Current health mismatch');
    }

    /**
     * @testWith [5, 3, 2]
     *           [4, 4, 0]
     *           [5, 10, -5]
     */
    public function testLoseHealth(int $maxHealth, int $losingAmount, int $expectedCurrentHealth): void
    {
        $equipment = new Equipment();
        $armorHealth = 4;
        $equipment->equip($this->createArmor(2, $armorHealth, 'Leather chest plate'));
        $stats = new EquipmentBoostedStats($equipment, new Stats(0,0, $maxHealth));

        $stats->loseHealth($losingAmount);

        self::assertEquals($expectedCurrentHealth + $armorHealth, $stats->currentHealth(), 'Current health mismatch');
    }

    /**
     * @testWith [6, 3, 2, 5]
     *           [4, 4, 1, 1]
     *           [10, 9, 9, 10]
     *           [10, 0, 10, 10]
     */
    public function testGainHealth(int $maxHealth, int $losingAmount, int $restoringAmount, int $expectedCurrentHealth): void
    {
        $equipment = new Equipment();
        $armorHealth = 4;
        $equipment->equip($this->createArmor(2, $armorHealth, 'Leather chest plate'));
        $stats = new EquipmentBoostedStats($equipment, new Stats(0,0, $maxHealth));

        $stats->loseHealth($losingAmount);
        $stats->restoreHealth($restoringAmount);

        self::assertEquals($expectedCurrentHealth + $armorHealth, $stats->currentHealth(), 'Current health mismatch');
    }

    private function createArmor(int $defence, int $health, string $name = 'Some Armor Name'): EquipmentItem
    {
        return EquipmentItem::bodyArmor(new Armor(
            new ArmorPrototype(
                Id::generate(),
                $name,
                $defence,
                $health
            )
        ));
    }
}
