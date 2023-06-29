<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\UnknownListServiceException;
use App\Service\Import\Airtable\Article\ALire\Lister as ALireLister;
use App\ValueObject\Import\Airtable\ImportedData;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class ImportedDataFactory implements ServiceSubscriberInterface
{
    public function __construct(
        private readonly ConfigFactory $configFactory,
        private readonly YamlListReader $yamlListReader,
        private readonly ContainerInterface $locator
    ) {
    }

    public function make(string $type): ImportedData
    {
        $config = $this->configFactory->make($type);
        // @var AbstractLister $lister
        try {
            $lister = $this->locator->get(
                str_replace('Config', 'Lister', $config::class)
            );
        } catch (ServiceNotFoundException $e) {
            throw new UnknownListServiceException($config::class, self::class);
        }

        return new ImportedData(
            label: $config->getPublicLabel(),
            fields: $this->yamlListReader->getFields($config),
            data: $lister->list()
        );
    }

    public static function getSubscribedServices(): array
    {
        return [
            ALireLister::class,
        ];
    }
}
