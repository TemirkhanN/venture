<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item\Effect;

interface EffectInterface
{
    public function name(): string;
    public function type(): EffectType;
    public function description(): string;
    public function power(): int;
}
