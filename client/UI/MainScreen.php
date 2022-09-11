<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use League\Event\EventDispatcher;
use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;
use TemirkhanN\Venture\Game\UI\Event\Transition;
use TemirkhanN\Venture\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class MainScreen implements GUIInterface
{
    use RendererTrait;

    public const EQUIP_ITEM = 'EquipItem';

    public function __construct(
        private readonly Cache $cache,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        /** @var Player $player */
        $player = $this->cache->get('player');

        if ($player === null) {
            $this->eventDispatcher->dispatch(new Transition(NewGame::class));

            return;
        }

        if ($input->hasAction()) {
            $this->performAction($player, $input);
        }

        $output->write(
            $this->render('main-screen', [
                'player'      => $player,
                'windowTitle' => 'Main screen',
            ])
        );
    }

    private function performAction(Player $player, InputInterface $input): void
    {
        $action = $input->getAction();

        if ($action === '') {
            throw new \RuntimeException('Action is not defined');
        }

        switch ($action) {
            case self::EQUIP_ITEM:
                $fromSlot = $input->getInt('fromSlot');

                foreach ($player->showInventory() as $slot) {
                    if ($slot->position === $fromSlot) {
                        $item = $slot->item;

                        if (!EquipmentItem::isEquipmentItem($item)) {
                            $this->error(sprintf('You can not equip %s', $item->name()));

                            return;
                        }

                        $player->equip(EquipmentItem::autoDetect($item));

                        $this->cache->save('player', $player);

                        return;
                    }
                }
                break;
            default:
                break;
        }
    }
}
