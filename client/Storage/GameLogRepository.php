<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use TemirkhanN\Venture\Utils\Networking\ConsumerInterface;

class GameLogRepository implements ConsumerInterface
{
    private \SplQueue $logs;

    public function __construct()
    {
        $this->logs = new \SplQueue();
    }

    public function addLog(string $log): void
    {
        $this->logs->enqueue($log);
    }

    /**
     * @return iterable<string>
     */
    public function viewLogs(): iterable
    {
        while (!$this->logs->isEmpty()) {
            yield $this->logs->dequeue();
        }
    }

    public function consume(string $message): void
    {
        $this->addLog($message);
    }
}
