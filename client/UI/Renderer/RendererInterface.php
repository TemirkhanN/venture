<?php

declare(strict_types=1);

namespace GameClient\UI\Renderer;

interface RendererInterface
{
    public function render(string $templateName, array $context): string;
}
