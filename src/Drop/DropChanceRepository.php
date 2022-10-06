<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Drop;

use TemirkhanN\Venture\Utils\Db\Id;
use TemirkhanN\Venture\Utils\Db\Table;
use TemirkhanN\Venture\Utils\Generic\Result;

class DropChanceRepository
{
    private readonly Table $tableGateway;

    public function __construct()
    {
        $this->tableGateway = new Table('drop');
    }

    /**
     * @param int $id
     *
     * @return Result<iterable<DropChance>>
     */
    public function findAllByNpcId(int $id): Result
    {
        $raw = $this->tableGateway->findById($id);
        if ($raw === null) {
            return Result::error('No drop details for the specified id');
        }

        return Result::success(array_map([$this, 'hydrateToObject'], $raw));
    }

    private function hydrateToObject(array $raw): DropChance
    {
        return new DropChance(new Id($raw['id']), (int)$raw['amount'], (float)$raw['chance']);
    }
}
