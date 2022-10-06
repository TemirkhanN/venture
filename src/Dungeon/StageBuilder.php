<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Dungeon;

use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Npc\NpcRepository;
use TemirkhanN\Venture\Utils\Id;

class StageBuilder
{
    private string $name;
    private array $monsters;

    private NpcRepository $npcRepository;

    public function __construct(NpcRepository $npcRepository)
    {
        $this->npcRepository = $npcRepository;

        $this->reset();
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function addMonster(Npc $npc): static
    {
        $this->monsters[] = $npc;

        return $this;
    }

    public function addMonsterById(Id $monsterId): static
    {
        return $this->addMonster($this->npcRepository->getById((string) $monsterId));
    }

    public function addRandomMonster(): static
    {
        return $this->addMonster($this->npcRepository->getRandom());
    }

    public function build(): Stage
    {
        $stage = new Stage($this->name, $this->monsters);

        $this->reset();

        return $stage;
    }

    public function reset(): void
    {
        $this->name = '';
        $this->monsters = [];
    }
}
