<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use League\Event\EventDispatcher;
use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Item\ItemRepository;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class NewGame implements GUIInterface
{
    use RendererTrait;

    public function __construct(
        private readonly Cache $cache,
        private readonly EventDispatcher $eventDispatcher,
        private readonly ItemRepository $itemRepository
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $playerName = $input->getString('name');
        if ($this->isValidPlayerName($playerName)) {
            $player = new Player($playerName, Stats::lowestStats(2));

            $player->loot(new Drop($this->itemRepository->getById(1), 10));
            $player->loot(new Drop($this->itemRepository->getById(2001), 1));
            $player->loot(new Drop($this->itemRepository->getById(2002), 1));
            $player->loot(new Drop($this->itemRepository->getById(1002), 1));

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
