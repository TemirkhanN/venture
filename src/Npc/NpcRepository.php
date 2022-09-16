<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc;

use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Utils\Db\Table;

class NpcRepository
{
    private Table $tableGateway;

    public function __construct()
    {
        $this->tableGateway = new Table('npcs');
    }

    public function findById(int $id): ?Npc
    {
        $data = $this->tableGateway->findById($id);

        if ($data === null) {
            return null;
        }

        return $this->hydrateToObject($id, $data);
    }

    public function getById(int $id): Npc
    {
        $npc = $this->findById($id);
        if ($npc === null) {
            throw new \RuntimeException(sprintf('Npc %d does not exist', $id));
        }

        return $npc;
    }

    public function getRandom(): Npc
    {
        $random = $this->tableGateway->getRandom();
        if ($random === null) {
            throw new \RuntimeException('Looks like there are no NPCs at all.');
        }

        return $this->hydrateToObject($random['id'], $random['data']);
    }

    private function hydrateToObject(int $id, array $npcData): Npc
    {
        return new Npc(
            $id,
            $npcData['name'],
            new Stats($npcData['attack'], $npcData['defence'], $npcData['health'])
        );
    }
}
