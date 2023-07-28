<?php

declare(strict_types=1);

namespace GameClient\Action\Cheat;

use GameClient\Component\Player\Player;
use TemirkhanN\Venture\Reward\Loot;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Storage\PlayerRepository;
use GameClient\Storage\Reference\Item;
use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;

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

        $player->player->loot(new Loot($this->itemRepository->getById(Item::CURRENCY_GOLD)->replicate(), $amount));

        $this->playerRepository->save($player);
    }
}
