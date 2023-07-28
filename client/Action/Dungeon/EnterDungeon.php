<?php

declare(strict_types=1);

namespace GameClient\Action\Dungeon;

use TemirkhanN\Venture\Dungeon\DungeonGenerator;
use GameClient\Action\ActionInterface;
use GameClient\Action\PlayerActionHandlerInterface;
use GameClient\Component\Player\Player;
use GameClient\Component\Player\PlayerState;
use GameClient\Storage\DungeonRepository;

class EnterDungeon implements PlayerActionHandlerInterface
{
    public const ACTION_NAME = 'EnterDungeon';

    public function __construct(
        private readonly DungeonGenerator $generator,
        private readonly DungeonRepository $dungeonRepository
    ) {

    }

    public function handle(Player $player, ActionInterface $action): void
    {
        if ($action->name() !== self::ACTION_NAME) {
            return;
        }

        $dungeon = $this->generator->generate(3, 4);

        $result = $dungeon->enter($player->player);
        if ($result->isSuccessful()) {
            $player->state = PlayerState::InDungeon;
            $this->dungeonRepository->save($dungeon);
        }
    }
}
