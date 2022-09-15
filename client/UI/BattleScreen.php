<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;

class BattleScreen implements GUIInterface
{
    public function __construct(private readonly PlayerRepository $playerRepository)
    {

    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $player = $this->playerRepository->find();

        if ($player === null) {

        }
    }
}
