<?php

declare(strict_types=1);

namespace GameClient\Action;

use Psr\Container\ContainerInterface;
use GameClient\Action\Battle\Attack;
use GameClient\Action\Battle\EndBattle;
use GameClient\Action\Battle\NextTurn;
use GameClient\Action\Cheat\GetGold;
use GameClient\Action\Cheat\Heal;
use GameClient\Action\Craft\CraftItem;
use GameClient\Action\Craft\ToggleCraftMenu;
use GameClient\Action\Dungeon\EnterDungeon;
use GameClient\Action\Dungeon\LeaveDungeon;
use GameClient\Action\Dungeon\ProceedDungeon;
use GameClient\Action\Inventory\EquipItem;
use GameClient\Action\Inventory\UseItem;
use GameClient\Action\Shop\BuyHealthPotion;
use GameClient\Storage\PlayerRepository;

class PlayerActionHandlerBus
{
    /**
     * @var array<string, PlayerActionHandlerInterface> $handlers
     */
    private array $handlers = [];

    public function __construct(
        private readonly PlayerRepository $playerRepository,
        ContainerInterface $container
    ) {
        $this->handlers = [
            EquipItem::ACTION_NAME       => $container->get(EquipItem::class),
            EnterDungeon::ACTION_NAME    => $container->get(EnterDungeon::class),
            ProceedDungeon::ACTION_NAME  => $container->get(ProceedDungeon::class),
            LeaveDungeon::ACTION_NAME    => $container->get(LeaveDungeon::class),
            Attack::ACTION_NAME          => $container->get(Attack::class),
            NextTurn::ACTION_NAME        => $container->get(NextTurn::class),
            EndBattle::ACTION_NAME       => $container->get(EndBattle::class),
            BuyHealthPotion::ACTION_NAME => $container->get(BuyHealthPotion::class),
            UseItem::ACTION_NAME         => $container->get(UseItem::class),
            ToggleCraftMenu::ACTION_NAME => $container->get(ToggleCraftMenu::class),
            CraftItem::ACTION_NAME       => $container->get(CraftItem::class),
            GetGold::ACTION_NAME         => $container->get(GetGold::class),
            Heal::ACTION_NAME            => $container->get(Heal::class),
        ];
    }

    public function performAction(ActionInput $action): void
    {
        $handler = $this->handlers[$action->name()] ?? null;
        if ($handler === null) {
            return;
        }

        $player = $this->playerRepository->find();
        if ($player === null) {
            return;
        }

        $handler->handle($player, $action);
    }
}
