<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Drop;

use TemirkhanN\Venture\Item\ItemRepositoryInterface;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Utils\Rng\Chance;

class GenerateDrop
{
    public function __construct(
        private readonly DropChanceRepository $dropChanceRepository,
        private readonly ItemRepositoryInterface $itemRepository
    ) {
    }

    /**
     * @param Npc $npc
     *
     * @return iterable<Drop>
     */
    public function execute(Npc $npc): iterable
    {
        $dropChances = $this->dropChanceRepository->findAllByNpcId($npc->id);
        if ($dropChances->isSuccessful()) {
            /** @var DropChance $dropChance */
            foreach ($dropChances->getData() as $dropChance) {
                if (Chance::raw($dropChance->chance)->roll()) {
                    $item = $this->itemRepository->getById($dropChance->item->value());

                    yield new Drop($item, $dropChance->amount);
                }
            }
        }
    }
}
