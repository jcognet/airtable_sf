<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Factory;

use App\Exception\Import\Airtable\UnknownFilterServiceException;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Import\Airtable\AbstractFilter;
use App\Service\Import\Airtable\Article\SeeAgain\Filter as SeeAgainFilter;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class ImportedDataFilterFactory implements ServiceSubscriberInterface
{
    public function __construct(
        private readonly ContainerInterface $locator
    ) {
    }

    public function make(AirtableConfigInterface $config): AbstractFilter
    {
        try {
            $filter = $this->locator->get(
                str_replace('Config', 'Filter', $config::class)
            );
        } catch (ServiceNotFoundException) {
            throw new UnknownFilterServiceException($config::class, self::class);
        }

        return $filter;
    }

    public static function getSubscribedServices(): array
    {
        return [
            SeeAgainFilter::class,
        ];
    }
}
