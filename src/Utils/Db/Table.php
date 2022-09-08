<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils\Db;

use DirectoryIterator;
use Symfony\Component\Yaml\Yaml;

class Table
{
    /**
     * @var array<int, array>
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

    public function findById(int $id): ?array
    {
        return $this->rows[$id] ?? null;
    }

    public function getRandom(): ?array
    {
        $pos = array_rand($this->rows);

        return $this->rows[$pos] ?? null;
    }

    private function loadData(string $fromFile): void
    {
        foreach (Yaml::parseFile($fromFile) as $identifier => $details) {
            if (isset($this->rows[$identifier])) {
                throw new \UnexpectedValueException('Multiple rows with the same id found.');
            }

            $this->rows[$identifier] = $details + ['id' => $identifier];
        }
    }
}
