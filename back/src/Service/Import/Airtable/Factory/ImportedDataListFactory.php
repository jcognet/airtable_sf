<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Factory;

use App\Exception\Import\Airtable\UnknownListServiceException;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Import\Airtable\AbstractLister;
use App\Service\Import\Airtable\Article\ALire\Lister as ALireLister;
use App\Service\Import\Airtable\Article\SeeAgain\Lister as SeeAgainLister;
use App\Service\Import\Airtable\Book\Book\Lister as BookLister;
use App\Service\Import\Airtable\File\File\Lister as FileLister;
use App\Service\Import\Airtable\Qcm\Question\Lister as QuestionLister;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class ImportedDataListFactory implements ServiceSubscriberInterface
{
    public function __construct(
        private readonly ContainerInterface $locator
    ) {
    }

    public function make(AirtableConfigInterface $config): AbstractLister
    {
        try {
            $lister = $this->locator->get(
                str_replace('Config', 'Lister', $config::class)
            );
        } catch (ServiceNotFoundException) {
            throw new UnknownListServiceException($config::class, self::class);
        }

        return $lister;
    }

    public static function getSubscribedServices(): array
    {
        return [
            ALireLister::class,
            SeeAgainLister::class,
            FileLister::class,
            QuestionLister::class,
            BookLister::class,
        ];
    }
}
