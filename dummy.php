<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Npc;
use TemirkhanN\Venture\Player;

require __DIR__ . '/vendor/autoload.php';

const MEMORY_PATH = __DIR__ . '/inmem.txt';

ob_start();

$battle = restoreBattleInfoFromMemory();

if ($battle === null) {
    $morlok = new Npc\Npc('Morlok', Stats::lowestStats());

    $battle = new Battle\Battle($morlok);

    $player = new Player\Player('Wilheim', new Stats(2, 0, 5));

    $battle->applyAction((new Player\Action\EngageBattle($player)));
}

if (!$battle->isOver()) {
    if ($battle->doesCurrentTurnBelongToPlayer()) {
        $action = new Player\Action\Attack();
    } else {
        $action = new Npc\Action\AttackPlayer();
    }
    $battle->applyAction($action);
}

renderBattle($battle);

saveBattleInfoIntoMemory($battle);

function renderBattle(Battle\Battle $battle): void
{
    ob_clean();

    $player = $battle->player();
    printf(
        '%s: HP %d/%d|ATT%d|DEF%d',
        $player->name(),
        $player->stats()->currentHealth,
        $player->stats()->maxHealth,
        $player->stats()->attack,
        $player->stats()->defence
    );

    $enemy = $battle->enemy();
    printf(
        '      %s: HP %d/%d|ATT%d|DEF%d',
        $enemy->name(),
        $enemy->stats()->currentHealth,
        $enemy->stats()->maxHealth,
        $enemy->stats()->attack,
        $enemy->stats()->defence
    );

    echo PHP_EOL . '____________________________' . PHP_EOL;
    foreach ($battle->logs() as $log) {
        echo $log . PHP_EOL;
    }
}

function restoreBattleInfoFromMemory(): ?Battle\Battle
{
    if (!file_exists(MEMORY_PATH)) {
        return null;
    }

    $contents = file_get_contents(MEMORY_PATH);
    if ($contents === '') {
        return null;
    }

    $battle = @unserialize($contents);

    if (!$battle instanceof Battle\Battle) {
        return null;
    }

    return $battle;
}

function saveBattleInfoIntoMemory(Battle\Battle $battle): void
{
    file_put_contents(MEMORY_PATH, serialize($battle));
}
