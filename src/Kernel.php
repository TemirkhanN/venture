<?php
declare(strict_types=1);

namespace TemirkhanN\Venture;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Npc\Event\NpcKilled;
use TemirkhanN\Venture\Reward\IssueRewards;

final class Kernel
{
    private static bool $isLoaded = false;
    private static ContainerInterface $container;

    private function __clone(){}

    public static function load(ContainerInterface $container): void
    {
        if (self::$isLoaded) {
            throw new \RuntimeException('Attempt to initialize kernel twice');
        }
        self::$container = $container;

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $container->get(EventDispatcherInterface::class);
        $eventDispatcher->subscribeTo(
            NpcKilled::class,
            static fn (NpcKilled $event) => self::getService(IssueRewards::class)->onNpcKilled($event)
        );

        self::$isLoaded = true;
    }

    /**
     * This method is only for class highlight purposes.
     *
     * @template T
     * @param class-string<T> $className
     *
     * @return T
     */
    private static function getService(string $className): object
    {
        return self::$container->get($className);
    }
}
