<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use League\Event\EventDispatcher;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class MainScreen implements GUIInterface
{
    public const ACTION_EQUIP_ITEM = 'EquipItem';
    public const ACTION_ENTER_DUNGEON = 'EnterDungeon';

    public function __construct(
        private readonly Cache $cache,
        private readonly EventDispatcher $eventDispatcher,
        private readonly RendererInterface $renderer
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        /** @var Player $player */
        $player = $this->cache->get('player');

        if ($player === null) {
            $this->eventDispatcher->dispatch(new Transition(NewGame::class));

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
