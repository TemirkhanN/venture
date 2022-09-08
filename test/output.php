<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Dungeon\Dungeon;
use TemirkhanN\Venture\Npc\Npc;
use TemirkhanN\Venture\Player\Player;

function fatalError(string $message): void {
    exit(PHP_EOL . sprintf("\033[31m %s \033[0m", $message) . PHP_EOL);
}

function renderPlayer(Player $player): void {
    echo sprintf(
            "Player: %s%s HP %d/%d|ATT%d|DEF%d",
            $player->name(),
            PHP_EOL,
            $player->stats()->currentHealth(),
            $player->stats()->maxHealth(),
            $player->stats()->attack(),
            $player->stats()->defence()
        ) . PHP_EOL;

    echo 'Equipment:' . PHP_EOL;
    $hasEquipment = false;
    foreach ($player->equipment() as $equippedItem) {
        $hasEquipment = true;
        $itemBonuses = [];
        if ($equippedItem->attack !== 0) {
            $itemBonuses[] = sprintf('+%dATT', $equippedItem->attack);
        }

        if ($equippedItem->defence !== 0) {
            $itemBonuses[] = sprintf('+%dDEF', $equippedItem->defence);
        }

        if ($equippedItem->health !== 0) {
            $itemBonuses[] = sprintf('+%dHP', $equippedItem->health);
        }

        echo sprintf(
                '    %s(%s)',
                $equippedItem->name,
                implode(', ', $itemBonuses)
            ) . PHP_EOL;
    }

    if (!$hasEquipment) {
        echo '  None' . PHP_EOL;
    }
}

function renderInventory(Player $player): void {
    echo 'Inventory: ' . PHP_EOL;
    foreach ($player->showInventory() as $slot) {
        if ($slot->position % 3 === 0) {
            echo PHP_EOL;
        }

        echo sprintf('| [%s:%d] |', $slot->item->name(), $slot->amountOfItems);
    }

    echo PHP_EOL;
}

function renderNpc(Npc $npc): void {
    printf(
        "Name:%s%s HP %d/%d|ATT%d|DEF%d" . PHP_EOL,
        $npc->name(),
        PHP_EOL,
        $npc->stats()->currentHealth(),
        $npc->stats()->maxHealth(),
        $npc->stats()->attack(),
        $npc->stats()->defence()
    );
}

function renderBattle(Battle $battle): void {
    echo PHP_EOL . '____________________________' . PHP_EOL;

    $enemy = $battle->enemy();

    renderNpc($enemy);

    echo PHP_EOL . '____________________________' . PHP_EOL;
    foreach ($battle->logs() as $log) {
        echo $log . PHP_EOL;
    }
}

function renderDungeon(Dungeon $dungeon): void {
    $player = $dungeon->player();
    if ($player !== null) {
        renderPlayer($player);
    }

    print('Dungeon:' . PHP_EOL);
    $currentStage = $dungeon->currentStage();

    foreach ($dungeon->stages() as $stage) {
        if ($stage === $currentStage) {
            echo '    (>>>) ';
        }
        printf('Stage: %s' . PHP_EOL, $stage->name());

        print('Enemies:' . PHP_EOL);
        foreach ($stage->monsters() as $monster) {
            renderNpc($monster);
        }
    }
}
