<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Scene;

use League\Event\EventDispatcher;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;
use TemirkhanN\Venture\Item\ItemRepository;
use TemirkhanN\Venture\Player\Player;

class NewGame implements SceneInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly EventDispatcher $eventDispatcher,
        private readonly ItemRepository $itemRepository,
        private readonly RendererInterface $renderer
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $player = $this->playerRepository->find();
        if ($player !== null) {
            return;
        }

        $playerName = $input->getString('name');
        if ($this->isValidPlayerName($playerName)) {
            $player = new Player($playerName, Stats::lowestStats(2));

            $player->loot(new Drop($this->itemRepository->getById(1), 10));
            $player->loot(new Drop($this->itemRepository->getById(2001), 1));
            $player->loot(new Drop($this->itemRepository->getById(2002), 1));
            $player->loot(new Drop($this->itemRepository->getById(1002), 1));

            $this->playerRepository->save($player);

            $this->eventDispatcher->dispatch(new Transition(Main::class));

            return;
        }

        $output->write($this->renderer->render('player-creation', ['title' => 'Player creation']));
    }

    private function isValidPlayerName(string $playerName): bool
    {
        return $playerName !== '' && !preg_match('#^[A-Za-z0-9]$#', $playerName);
    }
}
