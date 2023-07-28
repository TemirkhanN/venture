<?php

declare(strict_types=1);

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\EventDispatcher;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use GameClient\UI\Renderer\RendererInterface;
use GameClient\UI\Renderer\TwigRenderer;
use TemirkhanN\Venture\Item\Prototype\ItemRepository;
use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;
use TemirkhanN\Venture\Utils\Cache;

return (function () {
    $di = new Container();
    $di->defaultToShared(true);
    $di->delegate(new ReflectionContainer(true));

    $di->add(TwigRenderer::class)
        ->setAlias(RendererInterface::class)
        ->addArgument(ROOT_DIR . '/client/assets/view')
        ->addArgument($di);

    $di->add(Cache::class)->addArgument('stable');

    $di->add(GameClient\IO\OutputInterface::class, GameClient\IO\Printer::class);

    $di->add(EventDispatcherInterface::class, EventDispatcher::class);

    $di->add(ItemRepositoryInterface::class, ItemRepository::class);

    $di->add(ContainerInterface::class, $di);

    $di->add(GameClient\App::class)->addArguments([$di, GameClient\IO\Printer::class]);

return $di;
})();
