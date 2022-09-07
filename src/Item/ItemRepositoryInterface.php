<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

interface ItemRepositoryInterface
{
    public function findById(int $id): ?ItemInterface;

    public function getById(int $id): ItemInterface;
}
