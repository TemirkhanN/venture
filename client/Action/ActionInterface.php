<?php

declare(strict_types=1);

namespace GameClient\Action;

interface ActionInterface
{
    public const TYPE_MIXED = 'mixed';
    public const TYPE_STRING = 'string';
    public const TYPE_INT = 'int';

    public function name(): string;

    /**
     * @param string $key
     * @param string $type
     *
     * @return mixed
     */
    public function getInput(string $key, string $type = self::TYPE_MIXED): mixed;
}
