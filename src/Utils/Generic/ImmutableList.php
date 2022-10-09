<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Generic;

use IteratorAggregate;
use TemirkhanN\Venture\Utils\Iterating;
use Traversable;

/**
 * @template   T
 * @implements IteratorAggregate<T>
 */
final class ImmutableList implements IteratorAggregate
{
    /**
     * @var array<T>
     */
    private readonly array $items;

    /**
     * @param iterable<T> $items
     */
    public function __construct(iterable $items)
    {
        $this->items = Iterating::toArray($items);
    }

    /**
     * @return iterable<T>
     */
    public function getIterator(): Traversable
    {
        yield from $this->items;
    }

    /**
     * @return Traversable<T>
     */
    public function items(): Traversable
    {
        return $this->getIterator();
    }

    public function isEmpty(): bool
    {
        return $this->items === [];
    }
}
