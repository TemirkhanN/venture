<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use Psr\Container\ContainerInterface;
use TemirkhanN\Venture\Game\Action\Battle\Attack;
use TemirkhanN\Venture\Game\Action\Battle\EndBattle;
use TemirkhanN\Venture\Game\Action\Battle\NextTurn;
use TemirkhanN\Venture\Game\Action\Cheat\GetGold;
use TemirkhanN\Venture\Game\Action\Cheat\Heal;
use TemirkhanN\Venture\Game\Action\Craft\CraftItem;
use TemirkhanN\Venture\Game\Action\Craft\ToggleCraftMenu;
use TemirkhanN\Venture\Game\Action\Dungeon\EnterDungeon;
use TemirkhanN\Venture\Game\Action\Dungeon\LeaveDungeon;
use TemirkhanN\Venture\Game\Action\Dungeon\ProceedDungeon;
use TemirkhanN\Venture\Game\Action\Inventory\EquipItem;
use TemirkhanN\Venture\Game\Action\Inventory\UseItem;
use TemirkhanN\Venture\Game\Action\Shop\BuyHealthPotion;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;

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
