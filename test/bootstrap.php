<?php

declare(strict_types=1);

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Player\Player;

require __DIR__ . '/../vendor/autoload.php';

const MEMORY_DIR = __DIR__ . '/../var/';

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

function renderBattle(Battle $battle): void {
    echo PHP_EOL . '____________________________' . PHP_EOL;

    $enemy = $battle->enemy();
    echo sprintf(
            "Name:%s%s HP %d/%d|ATT%d|DEF%d",
            $enemy->name(),
            PHP_EOL,
            $enemy->stats()->currentHealth(),
            $enemy->stats()->maxHealth(),
            $enemy->stats()->attack(),
            $enemy->stats()->defence()
        ) . PHP_EOL;

    echo PHP_EOL . '____________________________' . PHP_EOL;
    foreach ($battle->logs() as $log) {
        echo $log . PHP_EOL;
    }
}

function saveDataIntoMemory(string $id, object $object): void {
    $memFile = sprintf('%s/%s.inmem', MEMORY_DIR, $id);

    file_put_contents($memFile, serialize($object));
}

function getDataFromMemory(string $id): ?object {
    $memFile = sprintf('%s/%s.inmem', MEMORY_DIR, $id);

    if (!file_exists($memFile)) {
        return null;
    }

    $contents = file_get_contents($memFile);
    if ($contents === '' || $contents === false) {
        return null;
    }

    return @unserialize($contents);
}
