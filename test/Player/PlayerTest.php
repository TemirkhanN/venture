<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use PHPUnit\Framework\TestCase;
use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Item\Armor;
use TemirkhanN\Venture\Item\Consumable;
use TemirkhanN\Venture\Item\Prototype\Armor as ArmorPrototype;
use TemirkhanN\Venture\Item\Prototype\ItemInterface as ItemPrototype;
use TemirkhanN\Venture\Item\Prototype\Weapon as WeaponPrototype;
use TemirkhanN\Venture\Item\Weapon;
use TemirkhanN\Venture\Utils\Id;

class PlayerTest extends TestCase
{
    private const PLAYER_NAME    = 'Cloud';
    private const PLAYER_ATTACK  = 10;
    private const PLAYER_DEFENCE = 5;
    private const PLAYER_HEALTH  = 23;

    public function testPlayerInitialCreation(): void
    {
        $player = $this->createPlayer();

        self::assertEquals(self::PLAYER_NAME, $player->name());
        self::assertPlayerStats($player, self::PLAYER_ATTACK, self::PLAYER_DEFENCE, self::PLAYER_HEALTH);
        self::assertEquals(1, $player->lvl(), 'Lvl mismatch');
        self::assertEquals(0, $player->exp(), 'Experience mismatch');
        self::assertTrue($player->isAlive(), 'Player shall be alive');
        self::assertTrue($player->recipeBook()->isEmpty(), 'Player shall not know any recipe int the beginning');
        self::assertTrue($player->equipment()->isEmpty(), 'Player shall not have any items in the beginning');
    }

    /**
     * @dataProvider equipAttemptsItemsProvider
     *
     * @param ItemPrototype $item
     * @param bool $shallBeAbleToEquip
     * @return void
     */
    public function testPlayerCanEquip(ItemPrototype $item, bool $shallBeAbleToEquip): void
    {
        $player = $this->createPlayer();

        self::assertSame($shallBeAbleToEquip, $player->canEquip($item));
    }

    public function equipAttemptsItemsProvider(): iterable
    {
        yield 'Shall be able to equip weapon' => [
            $this->createWeapon('Sword', 10),
            true,
        ];

        yield 'Shall be able to equip armor' => [
            $this->createArmor('Chainmail'),
            true,
        ];

        yield 'Shall not be able to equip consumables' => [
            $this->createConsumable('Pointless Potion'),
            false,
        ];
    }


    /**
     * @dataProvider equipmentProvider
     *
     * @param array<EquipmentItem> $equipment
     * @param array $expectedStats
     * @return void
     */
    public function testPlayerEquipment(array $equipment, array $expectedStats): void
    {
        $player = $this->createPlayer();

        foreach ($equipment as $item) {
            $player->equip($item);
        }

        self::assertPlayerStats($player, ...$expectedStats);
    }

    public function equipmentProvider(): iterable
    {
        yield 'Only a body armor' => [
            [
                EquipmentItem::autoDetect($this->createArmor('Cuirass', 2, 7)),
            ],
            [
                self::PLAYER_ATTACK + 0,
                self::PLAYER_DEFENCE + 2,
                self::PLAYER_HEALTH + 7,
            ],
        ];

        yield 'Only the weapon' => [
            [
                EquipmentItem::autoDetect($this->createWeapon('Sabre', 4)),
            ],
            [
                self::PLAYER_ATTACK + 4,
                self::PLAYER_DEFENCE + 0,
                self::PLAYER_HEALTH + 0,
            ],
        ];

        yield 'Only a body armor and a weapon' => [
            [
                EquipmentItem::autoDetect($this->createArmor('Cuirass', 2, 7)),
                EquipmentItem::autoDetect($this->createWeapon('Sabre', 4)),
            ],
            [
                self::PLAYER_ATTACK + 4,
                self::PLAYER_DEFENCE + 2,
                self::PLAYER_HEALTH + 7,
            ],
        ];
    }

    private function createPlayer(
        string $name = self::PLAYER_NAME,
        int $attack = self::PLAYER_ATTACK,
        int $defence = self::PLAYER_DEFENCE,
        int $health = self::PLAYER_HEALTH
    ): Player {
        return new Player($name, new Stats($attack, $defence, $health));
    }

    private function createArmor(string $name, int $bonusDefence = 0, int $bonusHealth = 0): Armor
    {
        return new Armor(
            new ArmorPrototype(
                Id::generate('testArmor'),
                $name,
                $bonusDefence,
                $bonusHealth
            )
        );
    }

    private function createWeapon(string $name, int $attack): Weapon
    {
        return new Weapon(new WeaponPrototype(Id::generate('testWeapon'), $name, $attack));
    }

    private function createConsumable(string $name): Consumable
    {
        return new Consumable(new \TemirkhanN\Venture\Item\Prototype\Consumable(
            Id::generate('testConsumable'),
            $name,
            []
        ));
    }

    private static function assertPlayerStats(Player $player, int $expectedAttack, int $expectedDefence, int $expectedHealth): void
    {
        $stats = $player->stats();

        self::assertEquals($expectedAttack, $stats->attack(), 'Attack does not match');
        self::assertEquals($expectedDefence, $stats->defence(), 'Defence does not match');
        self::assertEquals($expectedHealth, $stats->maxHealth(), 'Health does not match');
    }
}
