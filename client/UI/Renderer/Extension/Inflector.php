<?php

declare(strict_types=1);

namespace GameClient\UI\Renderer\Extension;

use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Inflector extends AbstractExtension
{
    public function __construct(private readonly ContainerInterface $serviceContainer)
    {

    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('itemName', $this->lazyCall(ItemDetail::class, 'getItemName')),
            new TwigFunction('characterImage', $this->lazyCall(CharacterDetail::class, 'getImagePath')),
        ];
    }

    private function lazyCall(string $extension, string $functionName)
    {
        return function(...$args) use ($extension, $functionName) {
            return call_user_func_array([$this->serviceContainer->get($extension), $functionName], $args);
        };
    }
}
