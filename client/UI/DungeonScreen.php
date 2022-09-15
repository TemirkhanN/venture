<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\DungeonRepository;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;

class DungeonScreen implements GUIInterface
{
    public function __construct(
        private readonly DungeonRepository $dungeonRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly RendererInterface $renderer
    )
    {

    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $dungeon = $this->dungeonRepository->find();
        if ($dungeon === null) {
            $this->eventDispatcher->dispatch(new Transition(MainScreen::class));

            return;
        }

        $output->write($this->renderer->render('dungeon/main', [
            'dungeon' => $dungeon,
            'title' => 'Dungeon',
        ]));
    }
}
