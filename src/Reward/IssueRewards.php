<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Reward;

use TemirkhanN\Venture\Item\Prototype\ItemRepositoryInterface;
use TemirkhanN\Venture\Npc\Event\NpcKilled;
use TemirkhanN\Venture\Utils\Rng\Chance;

/**
 * @internal Can only be used within Venture namespace
 */
readonly class IssueRewards
{
    public function __construct(
        private DropChanceRepository    $dropChanceRepository,
        private ItemRepositoryInterface $itemRepository,
        private ExperienceCalculator    $experienceCalculator
    ) {
    }

    public function onNpcKilled(NpcKilled $event): void
    {
        $npc = $event->npc;
        $player = $event->killer;

        if (!$player->isAlive()) {
            throw new \DomainException('Dead player can not receive rewards.');
        }

        if ($npc->isAlive()) {
            throw new \DomainException('NPC is still alive.');
        }

        $exp = $this->experienceCalculator->calculate($player, $npc);
        $player->gainExperience($exp);

        $dropChances = $this->dropChanceRepository->findAllByNpcId((string)$npc->id());
        if ($dropChances->isSuccessful()) {
            foreach ($dropChances->getData() as $dropChance) {
                if (Chance::raw($dropChance->chance)->roll()) {
                    $item = $this->itemRepository->getById((string) $dropChance->item);

                    $drop = new Loot($item->replicate(), $dropChance->amount);
                    $player->loot($drop);
                }
            }
        }
    }
}
