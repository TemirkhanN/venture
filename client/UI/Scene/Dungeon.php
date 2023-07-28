<?php

declare(strict_types=1);

namespace GameClient\UI\Scene;

use GameClient\IO\InputInterface;
use GameClient\IO\OutputInterface;
use GameClient\Storage\DungeonRepository;
use GameClient\Storage\PlayerRepository;
use GameClient\UI\SceneInterface;
use GameClient\UI\Renderer\RendererInterface;

class Dungeon implements SceneInterface
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
        if ($player === null) {
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
