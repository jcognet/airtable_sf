<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\Service\AirTable\Qcm\QuestionClient;
use App\Service\Contract\AirtableConfigInterface;
use App\Service\Contract\AirtableImporterInterface;
use App\ValueObject\Qcm\Question;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class Importer implements AirtableImporterInterface
{
    public function __construct(
        private readonly QuestionClient $questionClient,
        private readonly SerializerInterface $serializer,
        private readonly Config $config
    ) {
    }

    public function import(): array
    {
        $questions = $this->questionClient->findAll();
        $this->save($questions);

        return $questions;
    }

    public function getLabel(): string
    {
        return Question::class;
    }

    public function getConfig(): AirtableConfigInterface
    {
        return $this->config;
    }

    private function save(array $questions): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->config->getCompleteName(),
            $this->serializer->serialize(
                [
                    'data' => [
                        'questions' => array_values($questions),
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
