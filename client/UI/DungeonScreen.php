<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\DungeonRepository;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;

class DungeonScreen implements GUIInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly DungeonRepository $dungeonRepository,
        private readonly RendererInterface $renderer
    ) {

    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $player = $this->playerRepository->find();
        if ($player === null || !$player->isInDungeon()) {
            return;
        }

        $dungeon = $this->dungeonRepository->find($player);
        if ($dungeon === null) {
            return;
        }

        $output->write($this->renderer->render('dungeon/main', [
            'dungeon' => $dungeon,
            'title' => 'Dungeon',
        ]));
    }
}
