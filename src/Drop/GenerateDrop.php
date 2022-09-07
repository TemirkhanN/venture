<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Drop;

use TemirkhanN\Venture\Item\ItemRepository;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Utils\Db\Table;
use TemirkhanN\Venture\Utils\Rng\Chance;

class GenerateDrop
{
    private Table $tableGateway;
    private ItemRepository $itemRepository;

    public function __construct()
    {
        $this->tableGateway = new Table('drop');
        // TODO injection is a must
        $this->itemRepository = new ItemRepository();
    }

    /**
     * @param Npc $npc
     *
     * @return iterable<Drop>
     */
    public function execute(Npc $npc): iterable
    {
        $drops = $this->tableGateway->findById($npc->id) ?? [];

        foreach ($drops as $dropDetails) {
            if (Chance::raw($dropDetails['chance'])->roll()) {
                $item = $this->itemRepository->getById($dropDetails['id']);

                yield new Drop($item, $dropDetails['amount']);
            }
        }
    }
}
