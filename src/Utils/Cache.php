<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils;

class Cache
{
    private const STORAGE_PATTERN = '%s/%s.inmem';

    private string $memoryDir;

    /** @var array<string, mixed> */
    private array $refs = [];

    public function __construct(string $section)
    {
        if (preg_match('#[^\w]#', $section)) {
            throw new \RuntimeException('Inappropriate section.');
        }

        $this->memoryDir = preg_replace('#/{2,}#', '/', ROOT_DIR . sprintf('/var/%s', $section));
    }

    public function __destruct()
    {
        $refs = $this->refs;
        foreach ($refs as $key => $data) {
            $this->save($key, $data);
        }
    }

    public function save(string $key, mixed $data): void
    {
        if (is_resource($data)) {
            throw new \UnexpectedValueException('Resource can not be cached');
        }

        file_put_contents($this->generateFilePath($key), serialize($data));

        if (is_object($data)) {
            $this->refs[$key] = $data;
        }
    }

    public function get(string $key): mixed
    {
        $preSaved = $this->refs[$key] ?? null;
        if (is_object($preSaved)) {
            return $preSaved;
        }

        $memFile = $this->generateFilePath($key);

        if (!file_exists($memFile)) {
            return null;
        }

        $contents = file_get_contents($memFile);
        if ($contents === '' || $contents === false) {
            return null;
        }

        $data = @unserialize($contents);

        if (is_object($data)) {
            $this->refs[$key] = $data;
        }

        return $data;
    }

    public function remove(string $key): void
    {
        if (isset($this->refs[$key])) {
            unset($this->refs[$key]);
        }

        $memFile = $this->generateFilePath($key);

        file_exists($memFile) && unlink($memFile);
    }

    private function generateFilePath(string $cacheKey): string
    {
        return sprintf(self::STORAGE_PATTERN, $this->memoryDir, $cacheKey);
    }
}
