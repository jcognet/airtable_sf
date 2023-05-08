<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\Service\AirTable\Qcm\QuestionsClient;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class QcmImporter
{
    public function __construct(
        private readonly QuestionsClient $questionsClient,
        private readonly SerializerInterface $serializer,
        private readonly Config $config
    ) {
    }

    public function import(): array
    {
        $questions = $this->questionsClient->findAll();
        $this->save($questions);

        return $questions;
    }

    private function save(array $questions): void
    {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->config->getFileName(),
            $this->serializer->serialize(
                [
                    'data' => [
                        'questions' => $questions,
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
