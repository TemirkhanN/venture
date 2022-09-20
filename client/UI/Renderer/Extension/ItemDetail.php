<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Renderer\Extension;

use TemirkhanN\Venture\Craft\ItemId;
use TemirkhanN\Venture\Item\ItemRepositoryInterface;

class ItemDetail
{
    public function __construct(private readonly ItemRepositoryInterface $itemRepository)
    {

    }

    public function getItemName(ItemId $itemId): string
    {
        return $this->itemRepository->getById($itemId->id->value())->name();
    }
}
