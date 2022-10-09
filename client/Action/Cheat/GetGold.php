<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Cheat;

use TemirkhanN\Venture\Reward\Loot;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\Storage\Reference\Item;
use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;
use TemirkhanN\Venture\Player\Player;

class GetGold implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'cheat_get_gold';

    public function __construct(
        private readonly ItemRepositoryInterface $itemRepository,
        private readonly PlayerRepository $playerRepository
    ) {}

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $amount = abs($action->getInput('amount', ActionInterface::TYPE_INT));

        $player->loot(new Loot($this->itemRepository->getById(Item::CURRENCY_GOLD)->replicate(), $amount));

        $this->playerRepository->save($player);
    }
}
