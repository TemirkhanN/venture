<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class PlayerActionHandlerBus
{
    /**
     * @var array<string, PlayerActionHandlerInterface> $handlers
     */
    private array $handlers = [];

    /**
     * @param Cache $cache
     */
    public function __construct(private readonly Cache $cache)
    {
        $this->handlers = [
            EquipItem::ACTION_NAME => new EquipItem(),
        ];
    }

    public function tryToPerformAction(InputInterface $input): void
    {
        $action = $input->getAction();
        if ($action === '') {
            return;
        }

        $handler = $this->handlers[$action] ?? null;
        if ($handler === null) {
            return;
        }

        $player = $this->getPlayer();
        if ($player === null) {
            return;
        }

        $handler->handle($player, $input);

        $this->cache->save('player', $player);
    }

    private function getPlayer(): ?Player
    {
        /** @var Player|null $player */
        $player = $this->cache->get('player');

        if ($player === null) {
            return null;
        }

        if (!$player instanceof Player) {
            throw new \RuntimeException(sprintf('%s expected to be %s instance', gettype($player), Player::class));
        }

        return $player;
    }
}
