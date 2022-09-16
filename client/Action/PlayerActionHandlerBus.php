<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use Psr\Container\ContainerInterface;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

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
            EquipItem::ACTION_NAME => $container->get(EquipItem::class),
            EnterDungeon::ACTION_NAME => $container->get(EnterDungeon::class),
            ProceedDungeon::ACTION_NAME => $container->get(ProceedDungeon::class),
            LeaveDungeon::ACTION_NAME => $container->get(LeaveDungeon::class),
            Attack::ACTION_NAME => $container->get(Attack::class),
            NextTurn::ACTION_NAME => $container->get(NextTurn::class),
            EndBattle::ACTION_NAME => $container->get(EndBattle::class),
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
