<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use League\Event\EventDispatcher;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class NewGame implements GUIInterface
{
    use RendererTrait;

    public function __construct(
        private readonly Cache $cache,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $playerName = $input->getString('name');
        if ($this->isValidPlayerName($playerName)) {
            $player = new Player($playerName, Stats::lowestStats(2));

            $this->cache->save('player', $player);

            $this->eventDispatcher->dispatch(new Transition(MainScreen::class));

            return;
        }

        $output->write($this->render('player-creation', ['windowTitle' => 'Player creation']));
    }

    private function isValidPlayerName(string $playerName): bool
    {
        return $playerName !== '' && !preg_match('#^[A-Za-z0-9]$#', $playerName);
    }
}
