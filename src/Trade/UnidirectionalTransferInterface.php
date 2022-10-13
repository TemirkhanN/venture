<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Trade;

use TemirkhanN\Generic\ResultInterface;
use TemirkhanN\Venture\Character\CharacterInterface;

interface UnidirectionalTransferInterface
{
    public function isAffordable(CharacterInterface $to): bool;

    /**
     * @param CharacterInterface $by
     *
     * @return ResultInterface<void>
     */
    public function perform(CharacterInterface $by): ResultInterface;
}
