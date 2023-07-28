<?php
declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Networking;

interface ConsumerInterface
{
    public function consume(string $message): void;
}
