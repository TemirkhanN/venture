<?php

declare(strict_types=1);

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Item\Armor;
use TemirkhanN\Venture\Item\ItemRepository;
use TemirkhanN\Venture\Item\Weapon;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';


/** @var Player|null $player */
$player = getCache()->get('new-player');

if ($player === null) {
    fatalError('Player is not created. Call according script first.');
}

$repo = new ItemRepository();

$sword = Weapon::fromItem($repo->getById(2002));
$armor = Armor::fromItem($repo->getById(1001));

$player->equip(EquipmentItem::weapon($sword));
$player->equip(EquipmentItem::bodyArmor($armor));

renderPlayer($player);

getCache()->save('equipped-player', $player);
