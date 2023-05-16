<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable;

use App\Service\AirTable\AbstractClient;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Contract\AirtableImporterInterface;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractImporter implements AirtableImporterInterface
{
    public function __construct(
        private readonly AbstractClient $client,
        private readonly SerializerInterface $serializer,
        private readonly AirtableConfigInterface $config
    ) {
    }

    public function import(): array
    {
        $data = $this->client->findAll();
        $this->save($data);

        return $data;
    }

    public function getConfig(): AirtableConfigInterface
    {
        return $this->config;
    }

    public function getLabel(): string
    {
        return $this->config->getClass();
    }

    private function save(array $data): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->config->getCompleteName(),
            $this->serializer->serialize(
                [
                    'data' => [
                        $this->config->getDataEntryName() => array_values($data),
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
