<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Effect;

class Effect implements EffectInterface
{
    public function __construct(
        private readonly string $name,
        private readonly EffectType $type,
        private readonly string$description,
        private readonly int $power
    ) {

    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): EffectType
    {
        return $this->type;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function power(): int
    {
        return $this->power;
    }
}
