<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Rng;

interface ChanceInterface
{
    public function roll(): bool;
}
