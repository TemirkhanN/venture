<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

trait TypeCasterTrait
{
    public static function fromItem(ItemInterface $generic): static
    {
        if (!$generic instanceof static) {
            throw new \InvalidArgumentException('Type cast works only with the same type');
        }

        return $generic;
    }
}
