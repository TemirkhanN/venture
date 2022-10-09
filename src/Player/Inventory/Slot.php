<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;


use TemirkhanN\Venture\Item\ItemInterface;

class Slot
{
    public function __construct(
        public readonly int $position,
        public readonly ?ItemInterface $item,
        public readonly int $amountOfItems
    )
    {
        if ($this->item === null && $this->amountOfItems !== 0) {
            throw new \LogicException('Empty slot can not have amount indication.');
        }
    }

    public static function empty(int $position): self
    {
        return new self($position, null, 0);
    }

    public function isEmpty(): bool
    {
        return $this->item === null;
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

        if ($this->isEmpty()) {
            throw new \LogicException('This slot is empty.');
        }

        return new static($this->position, $this->item, $this->amountOfItems + $amount);
    }

    /**
     * #[Pure]
     *
     * @param int $amount
     *
     * @return $this
     */
    public function removeAmount(int $amount): static
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Can not decrease by negative amount');
        }

        if ($this->amountOfItems < $amount) {
            throw new \LogicException('Attempted to discard more items than there exists');
        }

        if ($this->isEmpty()) {
            throw new \LogicException('This slot is empty.');
        }

        return new static($this->position, $this->item, $this->amountOfItems - $amount);
    }

    /**
     * #[Pure]
     *
     * @param ItemInterface|null $with
     * @param int $amount
     *
     * @return $this
     */
    public function replace(?ItemInterface $with, int $amount): static
    {
        return new static($this->position, $with, $amount);
    }
}
