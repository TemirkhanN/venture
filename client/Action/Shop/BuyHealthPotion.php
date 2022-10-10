<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Shop;

use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Component\Player\PlayerState;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\Storage\Reference\Item;
use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;
use TemirkhanN\Venture\Trade\Purchase\Offer;
use TemirkhanN\Venture\Trade\Purchase\Purchase;

class BuyHealthPotion implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'BuyHealthPotion';

    private const POTION_PRICE = 10;

    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly ItemRepositoryInterface $itemRepository
    ) {

    }

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        if ($player->state !== PlayerState::Idle) {
            return;
        }

        $potion = $this->itemRepository->getById(Item::MINOR_HEALING_POTION);
        $gold = $this->itemRepository->getById(Item::CURRENCY_GOLD);

        $playerWillPay = new Offer();
        $playerWillPay->require($gold, self::POTION_PRICE);

        $playerWillReceive = new Offer();
        $playerWillReceive->require($potion, 1);
        $purchase = new Purchase($playerWillPay, $playerWillReceive);

        if (!$purchase->isAffordable($player->player)) {
            return;
        }

        $purchase->perform($player->player);

        $this->playerRepository->save($player);
    }
}
