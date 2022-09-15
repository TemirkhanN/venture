<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game;

use Psr\Container\ContainerInterface;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerBus;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\GUIInterface;
use TemirkhanN\Venture\Game\UI\MainScreen;

class App
{
    private readonly ContainerInterface $serviceLocator;
    private readonly InputInterface $input;
    private readonly OutputInterface $output;
    private readonly PlayerActionHandlerBus $playerActionHandler;

    private bool $isRunning = false;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->input = $serviceLocator->get(InputInterface::class);
        $this->output = $serviceLocator->get(OutputInterface::class);
        $this->playerActionHandler = $serviceLocator->get(PlayerActionHandlerBus::class);

        $this->serviceLocator = $serviceLocator;
    }

    public function run(): void
    {
        if ($this->isRunning) {
            throw new \RuntimeException('Application is already running');
        }

        $this->isRunning = true;

        $this->playerActionHandler->tryToPerformAction($this->input);

        $this->switchToWindow(MainScreen::class);
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
