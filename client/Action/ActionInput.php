<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action;

use TemirkhanN\Venture\Game\IO\InputInterface;

class ActionInput implements ActionInterface
{
    private function __construct(private readonly string $name, private readonly array $payload)
    {
        if ($name === '') {
            throw new \UnexpectedValueException('Action name can not be empty');
        }
    }

    public static function fromInput(InputInterface $input): ?self
    {
        $actionData = $input->get('action') ?? [];

        if (!is_array($actionData)) {
            return null;
        }

        $actionName = $actionData['name'] ?? '';
        if (!is_string($actionName) || $actionName === '') {
            return null;
        }

        unset($actionData['name']);

        return new self($actionName, $actionData);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function getInput(string $key, string $type = self::TYPE_MIXED): mixed
    {
        $value = $this->payload[$key] ?? null;

        return $this->castType($value, $type);
    }

    private function castType(mixed $value, string $type): mixed
    {
        switch ($type) {
            case self::TYPE_MIXED:
                return $value;
                break;
            case self::TYPE_STRING:
                if (!is_string($value)) {
                    throw new \UnexpectedValueException('Type expected to be string');
                }

                return (string) $value;
            case self::TYPE_INT:
                if (!is_integer($value)) {
                    throw new \UnexpectedValueException('Type expected to be integer');
                }
                return (int) $value;
            default:
                throw new \InvalidArgumentException('Unknown type');
        }
    }
}
