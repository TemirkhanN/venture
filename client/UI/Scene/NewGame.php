<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Scene;

use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Craft\RecipeRepository;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Reward\Loot;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\Storage\Reference\Item;
use TemirkhanN\Venture\Game\Storage\Reference\Recipe;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Item\Prototype\ItemRepository;
use TemirkhanN\Venture\Player\Player as PlayerModel;

class NewGame implements SceneInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ItemRepository $itemRepository,
        private readonly RecipeRepository $recipeRepository,
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
            $this->createNewPlayer($playerName);

            $this->eventDispatcher->dispatch(new Transition(Main::class));

            return;
        }

        $output->write($this->renderer->render('player-creation', ['title' => 'Player creation']));
    }

    private function isValidPlayerName(string $playerName): bool
    {
        return $playerName !== '' && !preg_match('#^[A-Za-z0-9]$#', $playerName);
    }

    private function createNewPlayer(string $playerName): void
    {
        // Todo some rpg-class preset?
        $player = new PlayerModel($playerName, Stats::lowestStats(2));

        $player->loot($this->getDrop(Item::CURRENCY_GOLD, 10));
        $player->loot($this->getDrop(Item::WEAPON_DAGGER, 1));
        $player->loot($this->getDrop(Item::ARMOR_LEATHER_ARMOR, 1));

        $player->learnRecipe($this->recipeRepository->getById(Recipe::LEATHER));
        $player->learnRecipe($this->recipeRepository->getById(Recipe::CHAIN_MAIL));

        $this->playerRepository->save(new Player($player));
    }

    private function getDrop(string $id, int $amount): Loot
    {
        return new Loot($this->itemRepository->getById($id)->replicate(), $amount);
    }
}
