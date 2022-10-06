<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Db;

use DirectoryIterator;
use Symfony\Component\Yaml\Yaml;

class Table
{
    /**
     * @var array<string, array>
     */
    private array $rows;

    public function __construct(string $tableName)
    {
        foreach (new DirectoryIterator(sprintf('%s/%s/', RESOURCE_DIR, $tableName)) as $fileInfo) {
            if($fileInfo->isFile() && $fileInfo->getExtension() === 'yaml' && $fileInfo->getRealPath() !== false) {
                $this->loadData($fileInfo->getRealPath());
            }
        }
    }

    public function findById(string $id): ?array
    {
        $data = $this->rows[$id] ?? null;
        if ($data === null) {
            return null;
        }
        unset($data['id']);

        return $data;
    }

    public function getRandom(): ?array
    {
        $pos = array_rand($this->rows);

        $data = $this->rows[$pos] ?? null;

        if ($data === null) {
            return null;
        }

        $id = $data['id'];
        unset($data['id']);

        return [
            'id' => $id,
            'data' => $data,
        ];
    }

    private function loadData(string $fromFile): void
    {
        foreach (Yaml::parseFile($fromFile) as $identifier => $details) {
            $id = (string) $identifier;
            if (isset($this->rows[$id])) {
                throw new \UnexpectedValueException('Multiple rows with the same id found.');
            }

            $this->rows[$id] = $details + ['id' => $id];
        }
    }
}
