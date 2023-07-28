<?php
declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Networking;

final class SystemMessageBus
{
    /**
     * @var ConsumerInterface[]
     */
    private static array $consumers = [];

    public static function addConsumer(ConsumerInterface $consumer): void
    {
        self::$consumers[spl_object_hash($consumer)] = $consumer;
    }

    public static function addMessage(string $message): void
    {
        foreach (self::$consumers as $consumer) {
            $consumer->consume($message);
        }
    }
}
