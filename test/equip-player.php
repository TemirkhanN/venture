<?php

declare(strict_types=1);

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Item\Prototype\Armor;
use TemirkhanN\Venture\Item\Prototype\ItemRepository;
use TemirkhanN\Venture\Item\Prototype\Weapon;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';


/** @var Player|null $player */
$player = getCache()->get('new-player');

if ($player === null) {
    fatalError('Player is not created. Call according script first.');
}

$repo = new ItemRepository();

$sword = $repo->getById('2002');
$armor = $repo->getById('1001');

$player->equip(EquipmentItem::autoDetect($sword));
$player->equip(EquipmentItem::autoDetect($armor));

renderPlayer($player);

getCache()->save('equipped-player', $player);
