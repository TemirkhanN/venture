<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\OutputInterface;

interface SceneInterface
{
    public function run(InputInterface $input, OutputInterface $output): void;
}
