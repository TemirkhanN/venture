<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;

class MainScreen implements GUIInterface
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
        if ($player === null) {
            $this->eventDispatcher->dispatch(new Transition(NewGame::class));

            return;
        }

        if ($player->isInDungeon()) {
            $this->eventDispatcher->dispatch(new Transition(DungeonScreen::class));

            return;
        }

        if ($player->isInFight()) {
            $this->eventDispatcher->dispatch(new Transition(BattleScreen::class));

            return;
        }

        $output->write(
            $this->renderer->render('main-screen', [
                'player' => $player,
                'title'  => 'Main screen',
            ])
        );
    }
}
