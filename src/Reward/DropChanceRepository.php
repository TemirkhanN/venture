<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Reward;

use TemirkhanN\Venture\Utils\Db\Table;
use TemirkhanN\Venture\Utils\Generic\Result;
use TemirkhanN\Venture\Utils\Id;

class DropChanceRepository
{
    private readonly Table $tableGateway;

    public function __construct()
    {
        $this->tableGateway = new Table('drop');
    }

    /**
     * @param string $id
     *
     * @return Result<iterable<DropChance>>
     */
    public function findAllByNpcId(string $id): Result
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
