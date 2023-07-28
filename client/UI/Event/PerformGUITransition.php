<?php

declare(strict_types=1);

namespace GameClient\UI\Event;

use League\Event\Listener;
use GameClient\App;

class PerformGUITransition implements Listener
{
    public function __construct(private readonly App $app) {}

    public function __invoke(object $event): void
    {
        if (!$event instanceof Transition) {
            return;
        }

        if ($event->isPropagationStopped()) {
            return;
        }
        $event->complete();

        $this->app->switchToScene($event->to());
    }
}
