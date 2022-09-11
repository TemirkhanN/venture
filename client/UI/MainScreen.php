<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use League\Event\EventDispatcher;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class MainScreen implements GUIInterface
{
    use RendererTrait;

    public function __construct(
        private readonly Cache $cache,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        /** @var Player $player */
        $player = $this->cache->get('player');

        $output->write(
            $this->render('main-screen', [
                'player' => $player,
                'windowTitle' => 'Main screen',
            ])
        );
    }
}
