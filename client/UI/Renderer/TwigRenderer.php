<?php

declare(strict_types=1);

namespace GameClient\UI\Renderer;

use Psr\Container\ContainerInterface;
use GameClient\UI\Renderer\Extension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    private Environment $twig;

    public function __construct(private string $templateDir, ContainerInterface $container)
    {
        $this->twig = new Environment(new FilesystemLoader([$this->templateDir]));

        $this->twig->addExtension(new Extension\Inflector($container));
    }

    public function render(string $templateName, array $context): string
    {
        $templateName .= '.html.twig';

        return $this->twig->render($templateName, $context);
    }
}
