<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game;

use Psr\Container\ContainerInterface;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\GUIInterface;
use TemirkhanN\Venture\Game\UI\MainScreen;
use TemirkhanN\Venture\Game\UI\NewGame;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class App
{
    private readonly ContainerInterface $serviceLocator;
    private readonly InputInterface $input;
    private readonly OutputInterface $output;
    private readonly Cache $cache;

    private bool $isRunning = false;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->input = $serviceLocator->get(InputInterface::class);
        $this->output = $serviceLocator->get(OutputInterface::class);
        $this->cache = $serviceLocator->get(Cache::class);

        $this->serviceLocator = $serviceLocator;
    }

    public function run(): void
    {
        if ($this->isRunning) {
            throw new \RuntimeException('Application is already running');
        }

        $this->isRunning = true;

        $player = $this->getPlayer();

        if ($player === null) {
            $this->switchToWindow(NewGame::class);

            return;
        }

        // todo state machine
        if ($player->state()->isIdle()) {
            $this->switchToWindow(MainScreen::class);

            return;
        }
    }

    private function getPlayer(): ?Player
    {
        /** @var Player|null $player */
        $player = $this->cache->get('player');

        if ($player === null) {
            return null;
        }

        if (!$player instanceof Player) {
            throw new \RuntimeException(sprintf('%s expected to be %s instance', gettype($player), Player::class));
        }

        return $player;
    }

    /**
     * @param class-string<GUIInterface> $guiClass
     *
     * @return void
     */
    public function switchToWindow(string $guiClass): void
    {
        $gui = $this->serviceLocator->get($guiClass);

        if (!$gui instanceof GUIInterface) {
            throw new \RuntimeException(sprintf('%s shall implemented %s', $guiClass, GUIInterface::class));
        }

        $gui->run($this->input, $this->output);
    }
}
