<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Service\Contract\AirtableConfigInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractLister
{
    public function __construct(
        private readonly AirtableConfigInterface $config,
        private readonly DenormalizerInterface $denormalizer
    ) {
    }

    public function list(): ?array
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->config->getCompleteName())) {
            return null;
        }

        $data = json_decode(file_get_contents($this->config->getCompleteName()), true, 512, JSON_THROW_ON_ERROR);
        $items = [];

        foreach ($data['data'][$this->config->getDataEntryName()] as $item) {
            $items[] = $this->denormalizer->denormalize($item, $this->config->getClass());
        }

        usort($items, [static::class, 'sort']);

        return $items;
    }

    abstract protected static function sort($a, $b): int;
}
