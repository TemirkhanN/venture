<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Prototype;

interface ItemRepositoryInterface
{
    public function findById(string $id): ?ItemInterface;

    public function getById(string $id): ItemInterface;
}
