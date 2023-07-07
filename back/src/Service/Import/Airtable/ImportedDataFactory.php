<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Exception\Import\Airtable\UnknownListServiceException;
use App\Service\Import\Airtable\Article\ALire\Lister as ALireLister;
use App\Service\Import\Airtable\Article\SeeAgain\Lister as SeeAgainLister;
use App\Service\Import\Airtable\File\File\Lister as FileLister;
use App\ValueObject\Import\Airtable\ImportedData;
use App\ValueObject\Import\Airtable\Sort;
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

    public function make(
        string $type,
        ?Sort $sort
    ): ImportedData {
        $config = $this->configFactory->make($type);
        // @var AbstractLister $lister
        try {
            $lister = $this->locator->get(
                str_replace('Config', 'Lister', $config::class)
            );
        } catch (ServiceNotFoundException) {
            throw new UnknownListServiceException($config::class, self::class);
        }

        return new ImportedData(
            label: $config->getPublicLabel(),
            fields: $this->yamlListReader->getFields($config),
            data: $lister->list($sort)
        );
    }

    public static function getSubscribedServices(): array
    {
        return [
            ALireLister::class,
            SeeAgainLister::class,
            FileLister::class,
        ];
    }
}
