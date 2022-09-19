<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game;

use Psr\Container\ContainerInterface;
use TemirkhanN\Venture\Game\Action\ActionInput;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerBus;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Game\UI\Scene\Main;

class App
{
    private readonly ContainerInterface $serviceLocator;
    private readonly InputInterface $input;
    private readonly OutputInterface $output;
    private readonly PlayerActionHandlerBus $playerActionHandler;

    private bool $isRunning = false;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->playerActionHandler = $serviceLocator->get(PlayerActionHandlerBus::class);

        $this->serviceLocator = $serviceLocator;
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        if ($this->isRunning) {
            throw new \RuntimeException('Application is already running');
        }

        $this->input = $input;
        $this->output = $output;

        $this->isRunning = true;

        $this->tryToPerformAction($input);

        $this->switchToScene(Main::class);
    }

    /**
     * @param class-string<SceneInterface> $guiClass
     *
     * @return void
     */
    public function switchToScene(string $guiClass): void
    {
        $gui = $this->serviceLocator->get($guiClass);

        if (!$gui instanceof SceneInterface) {
            throw new \RuntimeException(sprintf('%s shall implemented %s', $guiClass, SceneInterface::class));
        }

        $gui->run($this->input, $this->output);
    }

    private function tryToPerformAction(InputInterface $input): void
    {
        $action = ActionInput::fromInput($input);
        if ($action === null) {
            return;
        }

        $this->playerActionHandler->performAction($action);
    }
}
