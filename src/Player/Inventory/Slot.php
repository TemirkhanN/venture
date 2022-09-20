<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;

use TemirkhanN\Venture\Item\ItemInterface;

class Slot
{
    public function __construct(
        public readonly int $position,
        public readonly ItemInterface $item,
        public readonly int $amountOfItems
    )
    {

    }

    /**
     * #[Pure]
     *
     * @param int $amount
     * @return $this
     */
    public function addAmount(int $amount): static
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('To decrease amount use removeAmount');
        }

        return new static($this->position, $this->item, $this->amountOfItems + $amount);
    }

    /**
     * #[Pure]
     *
     * @param int $amount
     * @return $this
     */
    public function removeAmount(int $amount): static
    {
        if ($amount > 0) {
            throw new \UnexpectedValueException('To increase amount use addAmount');
        }

        if ($this->amountOfItems < $amount) {
            throw new \LogicException('Attempted to discard more items than there exists');
        }

        return new static($this->position, $this->item, $this->amountOfItems - $amount);
    }
}
