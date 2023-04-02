<?php
declare(strict_types=1);

namespace App\Service\Archive;

use Carbon\Carbon;
use Symfony\Component\Serializer\SerializerInterface;

class ExportWriterFetcher
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly NewsletterReadWriteHandler $dataIoHandler
    ) {
    }

    public function write(
        array $data,
        Carbon $date
    ): void {
        $this->dataIoHandler->write(
            $this->serializer->serialize(
                [
                    'data' => [
                        $data,
                    ],
                    'metadata' => [
                        'created' => $date,
                    ],
                ],
                'json',
            ),
            $date
        );
    }

    public function get(Carbon $date): ?array
    {
        $data = $this->dataIoHandler->read($date);

        if ($data === null) {
            return null;
        }

        return $data['data'];
    }
}
