<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Shop;

use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\Storage\Reference\Item;
use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;
use TemirkhanN\Venture\Player\Player;

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

        if (!$player->isIdle()) {
            return;
        }

        if ($player->gold() < self::POTION_PRICE) {
            return;
        }

        $potion = $this->itemRepository->getById(Item::MINOR_HEALING_POTION);

        $player->buyItems(self::POTION_PRICE, [new Drop($potion, 1)]);

        $this->playerRepository->save($player);
    }
}
