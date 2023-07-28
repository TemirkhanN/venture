<?php

declare(strict_types=1);

namespace GameClient\UI\Scene;

use GameClient\IO\InputInterface;
use GameClient\IO\OutputInterface;
use GameClient\Storage\BattleRepository;
use GameClient\Storage\PlayerRepository;
use GameClient\UI\SceneInterface;
use GameClient\UI\Renderer\RendererInterface;

class Battle implements SceneInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly BattleRepository $battleRepository,
        private readonly RendererInterface $renderer
    ) {

    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $player = $this->playerRepository->find();
        if ($player === null) {
            return;
        }

        $battle = $this->battleRepository->find($player);
        if ($battle === null) {
            return;
        }

        $output->write(
            $this->renderer->render('battle', [
                'battle' => $battle
            ])
        );
    }
}
