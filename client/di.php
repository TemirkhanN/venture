<?php

declare(strict_types=1);

use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\EventDispatcher;
use TemirkhanN\Venture\Game;
use TemirkhanN\Venture\Utils\Cache;

return (function () {
    $di = new Container();
    $di->defaultToShared(true);
    $di->delegate(new ReflectionContainer(true));

    $di->add(Cache::class)->addArgument('stable');

    $di->add(Game\IO\InputInterface::class, Game\IO\HttpInput::class)
       ->addArgument($_POST !== [] ? $_POST : $_GET);

    $di->add(Game\IO\OutputInterface::class, Game\IO\Printer::class);

    $di->add(EventDispatcher::class)
       ->addMethodCall('subscribeTo', [
           new StringArgument(Game\UI\Event\Transition::class),
           Game\UI\Event\PerformGUITransition::class
       ]);

    $di->add(Game\App::class)->addArgument($di);

return $di;
})();
