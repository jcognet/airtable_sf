<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\NoFileYamlException;
use App\Service\Contract\AirtableConfigInterface;
use App\ValueObject\Import\Airtable\Field;
use Symfony\Component\Yaml\Yaml;

class YamlListReader
{
    private const BASE_FILE_NAME = 'list.yaml';

    /**
     * @return Field[]
     */
    public function getFields(AirtableConfigInterface $config): array
    {
        $reflector = new \ReflectionClass($config);
        $dir = dirname($reflector->getFileName());
        $fileName = sprintf('%s/%s', $dir, self::BASE_FILE_NAME);

        if (!file_exists($fileName)) {
            throw new NoFileYamlException($config->getPublicKey(), $fileName);
        }

        $yamlFields = Yaml::parseFile($fileName)['fields'];
        $fields = [];

        foreach ($yamlFields as $yamlField) {
            $fields[] = new Field(
                property: $yamlField['property'] ?? $yamlField,
                label: $yamlField['label'] ?? null
            );
        }

        return $fields;
    }
}
