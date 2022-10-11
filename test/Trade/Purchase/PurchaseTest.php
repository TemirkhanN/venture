<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Trade\Purchase;

use PHPUnit\Framework\TestCase;
use TemirkhanN\Venture\Character\CharacterInterface;
use TemirkhanN\Venture\Character\Stats\Stats;
use TemirkhanN\Venture\Item\Prototype\Currency;
use TemirkhanN\Venture\Item\Prototype\Resource;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Reward\Loot;
use TemirkhanN\Venture\Utils\Id;

class PurchaseTest extends TestCase
{
    /**
     * @dataProvider affordablePurchaseProvider
     * @dataProvider unaffordablePurchaseProvider
     *
     * @param Offer $price
     * @param CharacterInterface $character
     * @param bool $expectedToBeAffordable
     *
     * @return void
     */
    public function testPurchaseIsAffordable(Offer $price, CharacterInterface $character, bool $expectedToBeAffordable): void
    {
        $prettyMuchNothing = new Offer();

        $purchase = new Purchase($price, $prettyMuchNothing);

        self::assertEquals($expectedToBeAffordable, $purchase->isAffordable($character));
    }

    public function affordablePurchaseProvider(): iterable
    {
        $gold      = new Currency(Id::generate(), 'Gold');
        $hide      = new Resource(Id::generate(), 'Animal Hide');
        $character = new Player('Cloud', Stats::lowestStats());

        $character->loot(new Loot($gold->replicate(), 15));
        $character->loot(new Loot($hide->replicate(), 4));

        $price = new Offer();
        $price->require($gold, 15);
        $price->require($hide, 4);

        yield 'Every player item is in the list' => [
            $price,
            clone $character,
            true,
        ];

        $price = new Offer();
        $price->require($gold, 15);

        yield 'Part of items is in the list' => [
            $price,
            clone $character,
            true,
        ];

        yield 'Price is free of charge' => [
            new Offer(),
            new Player('Cloud', Stats::lowestStats()),
            true,
        ];
    }

    public function unaffordablePurchaseProvider(): iterable
    {
        $gold      = new Currency(Id::generate(), 'Gold');
        $hide      = new Resource(Id::generate(), 'Animal Hide');
        $character = new Player('Cloud', Stats::lowestStats());

        $character->loot(new Loot($gold->replicate(), 15));
        $character->loot(new Loot($hide->replicate(), 4));

        $price = new Offer();
        $price->require($gold, 15);
        $price->require($hide, 5);

        yield 'Every player item is in the list but only ones amount is sufficient' => [
            $price,
            clone $character,
            false,
        ];

        $price = new Offer();
        $price->require($gold, 16);

        yield 'Part of items is in the list but amount is insufficient' => [
            $price,
            clone $character,
            false,
        ];
    }

    public function testPerformDonationlikePurchase(): void
    {
        $gold      = new Currency(Id::generate(), 'Gold');
        $hide      = new Resource(Id::generate(), 'Animal Hide');
        $character = new Player('Cloud', Stats::lowestStats());

        $character->loot(new Loot($gold->replicate(), 15));
        $character->loot(new Loot($hide->replicate(), 4));

        $price = new Offer();
        $price->require($gold, 6);
        $price->require($hide, 3);

        $prettyMuchNothing = new Offer();

        $purchase = new Purchase($price, $prettyMuchNothing);

        $result = $purchase->perform($character);

        self::assertTrue($result->isSuccessful(), sprintf('Could not perform the purchase:%s', $result->getError()));
        self::assertCharacterHasItems($character, [
            [
                'itemId' => $gold->id(),
                'amount' => 15 - 6,
            ],
            [
                'itemId' => $hide->id(),
                'amount' => 4 - 3,
            ],
        ]);
    }

    /**
     * @param CharacterInterface $character
     * @param array<array{itemId: Id, amount: int}> $items
     *
     * @return void
     */
    private static function assertCharacterHasItems(CharacterInterface $character, array $items): void
    {
        if ($items === []) {
            return;
        }

        $requiredItems = [];
        foreach ($items as $item) {
            $itemId = (string)$item['itemId'];
            $existingAmount = $requiredItems[$itemId] ?? 0;
            $requiredItems[$itemId] = $existingAmount + $item['amount'];
        }

        foreach ($character->showInventory() as $slot) {
            if ($requiredItems === []) {
                break;
            }

            if ($slot->isEmpty()) {
                continue;
            }

            $itemId = (string)$slot->item->id();
            if (!isset($requiredItems[$itemId])) {
                continue;
            }

            if ($requiredItems[$itemId] <= $slot->amountOfItems) {
                unset($requiredItems[$itemId]);
            } else {
                $requiredItems[$itemId] -= $slot->amountOfItems;
            }
        }

        self::assertEmpty($requiredItems, 'Player does not have specified items');
    }
}
