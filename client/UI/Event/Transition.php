<?php

declare(strict_types=1);

namespace GameClient\UI\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use GameClient\UI\SceneInterface;

class Transition implements StoppableEventInterface
{
    /**
     * @var class-string<SceneInterface>
     */
    private string $to;

    private bool $isComplete = false;

    public function __construct(string $to)
    {
        $this->to = $to;
    }

    public function to(): string
    {
        return $this->to;
    }

    public function complete(): void
    {
        $this->isComplete = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isComplete;
    }
}
