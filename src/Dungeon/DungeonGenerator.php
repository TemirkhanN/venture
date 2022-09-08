<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Dungeon;

class DungeonGenerator
{
    private StageBuilder $stageBuilder;

    // non shared service
    public function __construct(StageBuilder $stageBuilder)
    {
        $this->stageBuilder = $stageBuilder;
    }

    public function generate(int $maxFloor, int $maxMobsPerFloor): Dungeon
    {
        // todo validate


        $stages = [];
        for ($i = 0; $i < $maxFloor; $i++) {
            $this->stageBuilder->setName('Dark depths ' . $i + 1);
            for ($j = 0; $j < mt_rand(1, $maxMobsPerFloor); $j++) {
                $this->stageBuilder->addRandomMonster();
            }
            $stages[] = $this->stageBuilder->build();
        }

        return new Dungeon($stages);
    }
}
