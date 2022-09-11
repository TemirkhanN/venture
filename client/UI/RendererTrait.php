<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\UI;

trait RendererTrait
{
    private array $errors = [];

    final protected function render(string $template, array $data = []): string
    {
        return $this->renderTemplate('main-template', [
            'title' => $data['windowTitle'] ?? null,
            'content' => $this->renderTemplate($template, $data),
            'errors' => $this->errors,
        ]);
    }

    protected function error(string $error): void
    {
        $this->errors[] = $error;
    }

    private function renderTemplate(string $template, array $data = []): string
    {
        $templatePath = __DIR__ . sprintf('/view/%s.html.php', $template);

        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Template is not found');
        }

        ob_start();
        extract($data);
        require $templatePath;

        return (string) ob_get_clean();
    }
}
