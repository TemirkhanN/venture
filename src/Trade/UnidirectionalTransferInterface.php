<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Trade;

use TemirkhanN\Venture\Character\CharacterInterface;
use TemirkhanN\Venture\Utils\Generic\Result;

interface UnidirectionalTransferInterface
{
    public function isAffordable(CharacterInterface $to): bool;

    /**
     * @param CharacterInterface $by
     *
     * @return Result<void>
     */
    public function perform(CharacterInterface $by): Result;
}
