<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Scene;

use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;
use TemirkhanN\Venture\Player\Player;

class Main implements SceneInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly RendererInterface $renderer
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $player = $this->playerRepository->find();

        $scene = $this->getActiveScene($player);
        if ($scene !== null) {
            $this->eventDispatcher->dispatch(new Transition($scene));

            return;
        }

        $output->write(
            $this->renderer->render('main-screen', [
                'player' => $player,
                'title'  => 'Main screen',
            ])
        );
    }

    private function getActiveScene(?Player $player): ?string
    {
        switch (true) {
            case $player === null:
                return NewGame::class;
            case $player->isInDungeon():
                return Dungeon::class;
            case $player->isInFight():
                return Battle::class;
            case $player->isCrafting():
                return Craft::class;
            default:
                return null;
        }
    }
}
