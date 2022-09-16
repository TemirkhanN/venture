<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\BattleRepository;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;

class BattleScreen implements GUIInterface
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
        if ($player === null || !$player->isInFight()) {
            return;
        }

        $battle = $this->battleRepository->find();
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
