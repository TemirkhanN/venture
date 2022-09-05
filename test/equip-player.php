<?php

declare(strict_types=1);

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Item\Armor;
use TemirkhanN\Venture\Item\Weapon;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';


/** @var Player|null $player */
$player = getDataFromMemory('new-player');

if ($player === null) {
    fatalError('Player is not created. Call according script first.');
}

$sword = new Weapon('Broadsword', 2);
$armor = new Armor('Chain mail', 1, 3);
$player->equip(EquipmentItem::weapon($sword));
$player->equip(EquipmentItem::bodyArmor($armor));

renderPlayer($player);

saveDataIntoMemory('equipped-player', $player);
