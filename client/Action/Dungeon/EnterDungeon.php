<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Dungeon;

use TemirkhanN\Venture\Dungeon\DungeonGenerator;
use TemirkhanN\Venture\Game\Action\ActionInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Component\Player\PlayerState;
use TemirkhanN\Venture\Game\Storage\DungeonRepository;

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
