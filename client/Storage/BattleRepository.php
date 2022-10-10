<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Game\Component\Player\Player;
use TemirkhanN\Venture\Utils\Cache;

class BattleRepository extends AbstractObjectStorage
{
    private const CACHE_KEY = 'player_battle';

    public function __construct(Cache $cache, private readonly DungeonRepository $dungeonRepository)
    {
        parent::__construct($cache);
    }

    public function find(Player $player): ?Battle
    {
        /** @var Battle|null $battle */
        $battle = $this->getObject(self::CACHE_KEY, Battle::class);

        if ($battle !== null) {
            (new \ReflectionProperty($battle, 'player'))->setValue($battle, $player->player);
        }

        return $battle;
    }

    public function save(Battle $battle): void
    {
        $this->saveObject(self::CACHE_KEY, $battle);
        $this->syncWithDungeon($battle);
    }

    public function end(Battle $battle): void
    {
        $this->deleteObject($battle);
    }

    /**
     * @TODO Memory serialization wakeup stuff. Shall be removed after entity relationship manager introduction
     *
     * @param Battle $battle
     * @return void
     */
    private function syncWithDungeon(Battle $battle): void
    {
        $dungeon = $this->dungeonRepository->find(new Player($battle->player()));
        if ($dungeon === null) {
            return;
        }

        $actualValue = $battle->enemy();

        foreach ($dungeon->stages() as $stage) {
            foreach ($stage->monsters() as $monster) {
                if ($monster->instanceId() === $actualValue->instanceId()) {
                    if ($monster->stats()->currentHealth() > $actualValue->stats()->currentHealth()) {
                        $monster->loseHp(
                            $monster->stats()->currentHealth() - $actualValue->stats()->currentHealth()
                        );
                    } else {
                        $monster->restoreHp(
                            $actualValue->stats()->currentHealth() - $monster->stats()->currentHealth()
                        );
                    }

                    return;
                }
            }
        }

        $this->dungeonRepository->save($dungeon);
    }
}
