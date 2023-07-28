<?php

declare(strict_types=1);

namespace GameClient\UI;

use GameClient\IO\InputInterface;
use GameClient\IO\OutputInterface;

interface SceneInterface
{
    public function run(InputInterface $input, OutputInterface $output): void;
}
