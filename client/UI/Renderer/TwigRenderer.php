<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    private Environment $twig;

    public function __construct(private string $templateDir)
    {
        $this->twig = new Environment(new FilesystemLoader([$this->templateDir]));
    }

    public function render(string $templateName, array $context): string
    {
        $templateName .= '.html.twig';

        return $this->twig->render($templateName, $context);
    }
}
