<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils;

class Cache
{
    private const STORAGE_PATTERN = '%s/%s.inmem';

    private string $memoryDir;

    public function __construct(string $section)
    {
        if (preg_match('#[^\w]#', $section)) {
            throw new \RuntimeException('Inappropriate section.');
        }

        $this->memoryDir = ROOT_DIR . sprintf('/var/%s/', $section);
    }

    public function save(string $key, mixed $data): void
    {
        if (is_resource($data)) {
            throw new \UnexpectedValueException('Resource can not be cached');
        }

        file_put_contents($this->generateFilePath($key), serialize($data));
    }

    public function get(string $id): mixed
    {
        $memFile = $this->generateFilePath($id);

        if (!file_exists($memFile)) {
            return null;
        }

        $contents = file_get_contents($memFile);
        if ($contents === '' || $contents === false) {
            return null;
        }

        return @unserialize($contents);
    }

    private function generateFilePath(string $cacheKey): string
    {
        return sprintf(self::STORAGE_PATTERN, $this->memoryDir, $cacheKey);
    }
}
