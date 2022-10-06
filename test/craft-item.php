<?php

declare(strict_types=1);

use TemirkhanN\Venture\Craft\RecipeRepository;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Item\Prototype\ItemRepository;
use TemirkhanN\Venture\Player\Action\Craft;
use TemirkhanN\Venture\Player\Player;

require_once __DIR__ .'/bootstrap.php';

/** @var Player|null $player */
$player = getCache()->get('new-player');

if ($player === null) {
    fatalError('Player is not created/equipped. Call according script firsts.');
}

$itemRepository = new ItemRepository();
$recipeRepository = new RecipeRepository();

$animalHide = $itemRepository->getById(201);
$player->loot(new Drop($animalHide, 9));

$leatherRecipe = $recipeRepository->getById(1);

(new Craft($player, $itemRepository))->perform($leatherRecipe);

renderInventory($player);

getCache()->save('new-player', $player);
