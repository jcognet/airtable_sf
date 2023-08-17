<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Enum\Import\Airtable\Order;
use App\Exception\Import\Airtable\UnknownFieldException;
use App\Exception\Import\Airtable\UnknownFilterServiceException;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Import\Airtable\Factory\ImportedDataFilterFactory;
use App\ValueObject\Import\Airtable\Sort;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractLister
{
    private ?AbstractFilter $filter = null;

    public function __construct(
        private readonly AirtableConfigInterface $config,
        private readonly DenormalizerInterface $denormalizer,
        private readonly ImportedDataFilterFactory $filterFactory,
    ) {
        try {
            $this->filter = $this->filterFactory->make($config);
        } catch (UnknownFilterServiceException) {
            $this->filter = null;
        }
    }

    public function list(Sort $sort = null, ?string $filter = null): ?array
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

        $items = $this->filter($items, $filter);

        if ($sort === null) {
            usort($items, [static::class, 'sort']);
        } else {
            $functionName = sprintf('get%s', $sort->getProperty());

            try {
                if ($sort->getOrder() === Order::ASC) {
                    usort($items, fn ($a, $b) => $a->{$functionName}() <=> $b->{$functionName}());
                } else {
                    usort($items, fn ($a, $b) => $b->{$functionName}() <=> $a->{$functionName}());
                }
            } catch (\Throwable $e) {
                throw new UnknownFieldException($e->getMessage());
            }
        }

        return $items;
    }

    abstract protected static function sort($a, $b): int;

    private function filter(array $items, ?string $filter = null): array
    {
        if ($filter && $this->filter) {
            $items = $this->filter->filter($filter, $items);
        }

        return $items;
    }
}
