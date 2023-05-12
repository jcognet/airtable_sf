<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Holliday\Holliday;

use App\Service\AirTable\Holliday\HollidayClient;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Contract\AirtableImporterInterface;
use App\ValueObject\Holliday\Holliday;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class Importer implements AirtableImporterInterface
{
    public function __construct(
        private readonly HollidayClient $hollidayClient,
        private readonly SerializerInterface $serializer,
        private readonly Config $config
    ) {
    }

    public function import(): array
    {
        $hollidays = $this->hollidayClient->findAll();
        $this->save($hollidays);

        return $hollidays;
    }

    public function getLabel(): string
    {
        return Holliday::class;
    }

    public function getConfig(): AirtableConfigInterface
    {
        return $this->config;
    }

    private function save(array $hollidays): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->config->getCompleteName(),
            $this->serializer->serialize(
                [
                    'data' => [
                        'hollidays' => array_values($hollidays),
                    ],
                    'metadata' => [
                        'created' => Carbon::now(),
                    ],
                ],
                'json'
            )
        );
    }
}
