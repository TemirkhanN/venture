<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game;

use League\Event\EventDispatcher;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game\Action\ActionInput;
use TemirkhanN\Venture\Game\Action\PlayerActionHandlerBus;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\Event\PerformGUITransition;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Game\UI\Scene\Main;

class App
{
    private InputInterface $input;
    private readonly PlayerActionHandlerBus $playerActionHandler;

    private bool $isRunning = false;

    public function __construct(
        private readonly ContainerInterface $serviceLocator,
        private readonly OutputInterface $output
    ) {
    }

    public function run(InputInterface $input): void
    {
        $this->input = $input;

        $this->initialize();
        $this->tryToPerformAction();
        $this->switchToScene(Main::class);
    }

    /**
     * @param class-string<SceneInterface> $guiClass
     *
     * @return void
     */
    public function switchToScene(string $guiClass): void
    {
        if (!$this->isRunning) {
            throw new \RuntimeException('Can not switch the scene in inactive application');
        }

        $gui = $this->serviceLocator->get($guiClass);

        if (!$gui instanceof SceneInterface) {
            throw new \RuntimeException(sprintf('%s shall implemented %s', $guiClass, SceneInterface::class));
        }

        $gui->run($this->input, $this->output);
    }

    private function initialize(): void
    {
        if ($this->isRunning) {
            return;
        }
        $this->isRunning = true;

        $this->playerActionHandler = $this->serviceLocator->get(PlayerActionHandlerBus::class);

        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->serviceLocator->get(EventDispatcherInterface::class);

        $eventDispatcher->subscribeTo(
            Transition::class,
            $this->serviceLocator->get(PerformGUITransition::class)
        );
    }

    private function tryToPerformAction(): void
    {
        $action = ActionInput::fromInput($this->input);
        if ($action === null) {
            return;
        }

        $this->playerActionHandler->performAction($action);
    }
}
