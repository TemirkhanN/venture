<?php

declare(strict_types=1);

use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\EventDispatcher;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;
use TemirkhanN\Venture\Game\UI\Renderer\TwigRenderer;
use TemirkhanN\Venture\Item\ItemRepository;
use TemirkhanN\Venture\Item\ItemRepositoryInterface;
use TemirkhanN\Venture\Utils\Cache;

return (function () {
    $di = new Container();
    $di->defaultToShared(true);
    $di->delegate(new ReflectionContainer(true));

    $di->add(TwigRenderer::class)
        ->setAlias(RendererInterface::class)
        ->addArgument(ROOT_DIR . '/client/UI/view');

    $di->add(Cache::class)->addArgument('stable');

    $di->add(Game\IO\OutputInterface::class, Game\IO\Printer::class);

    $di->add(EventDispatcherInterface::class, EventDispatcher::class)
       ->addMethodCall('subscribeTo', [
           new StringArgument(Game\UI\Event\Transition::class),
           Game\UI\Event\PerformGUITransition::class
       ]);

    $di->add(ItemRepositoryInterface::class, ItemRepository::class);

    $di->add(ContainerInterface::class, $di);

return $di;
})();
