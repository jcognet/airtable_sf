<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\NoFileYamlException;
use App\Service\Contract\AirtableConfigInterface;
use App\ValueObject\Import\Airtable\Field;
use App\ValueObject\Import\Airtable\Filter;
use Symfony\Component\Yaml\Yaml;

class YamlListReader
{
    private const BASE_FILE_NAME = 'list.yaml';

    /**
     * @return Field[]
     */
    public function getFields(AirtableConfigInterface $config): array
    {
        $yamlFields = $this->getContent($config)['fields'];
        $fields = [];

        foreach ($yamlFields as $yamlField) {
            $fields[] = new Field(
                property: $yamlField['property'] ?? $yamlField,
                label: $yamlField['label'] ?? null,
                isSortable: $yamlField['is_sortable'] ?? true,
            );
        }

        return $fields;
    }

    public function getFilters(AirtableConfigInterface $config): array
    {
        $content = $this->getContent($config);

        if (!isset($content['filters'])) {
            return [];
        }

        $yamlFilters = $content['filters'];
        $filters = [];

        foreach ($yamlFilters as $yamlField) {
            $filters[] = new Filter(
                property: $yamlFiel,
            );
        }

        return $filters;
    }

    private function getContent(AirtableConfigInterface $config): mixed
    {
        $reflector = new \ReflectionClass($config);
        $dir = dirname($reflector->getFileName());
        $fileName = sprintf('%s/%s', $dir, self::BASE_FILE_NAME);

        if (!file_exists($fileName)) {
            throw new NoFileYamlException($config->getPublicKey(), $fileName);
        }

        return Yaml::parseFile($fileName);
    }
}
