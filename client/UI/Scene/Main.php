<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Scene;

use Psr\EventDispatcher\EventDispatcherInterface;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Game\Component\Player\PlayerState;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\Storage\GameLogRepository;
use TemirkhanN\Venture\Game\Storage\PlayerRepository;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Game\UI\SceneInterface;
use TemirkhanN\Venture\Game\UI\Renderer\RendererInterface;

class Main implements SceneInterface
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly RendererInterface $renderer,
        private readonly GameLogRepository $gameLogRepository
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $gameLogs = $this->getGameLogs();
        if ($gameLogs !== []) {
            $output->write(
                $this->renderer->render('game-logs', [
                    'title'    => 'Details',
                    'gameLogs' => $gameLogs,
                ])
            );

            return;
        }

        $player = $this->playerRepository->find();

        $scene = $this->getActiveScene($player);
        if ($scene !== null) {
            $this->eventDispatcher->dispatch(new Transition($scene));

            return;
        }

        $output->write(
            $this->renderer->render('main-screen', [
                'player' => $player->player,
                'title'  => 'Main screen',
            ])
        );
    }

    private function getActiveScene(?Player $player): ?string
    {
        switch (true) {
            case $player === null:
                return NewGame::class;
            case $player->state === PlayerState::InDungeon:
                return Dungeon::class;
            case $player->state === PlayerState::Fighting:
                return Battle::class;
            case $player->state === PlayerState::Crafting:
                return Craft::class;
            default:
                return null;
        }
    }

    private function getGameLogs(): array
    {
        $logs = [];
        foreach ($this->gameLogRepository->viewLogs() as $log) {
            $logs[] = $log;
        }

        return $logs;
    }
}
