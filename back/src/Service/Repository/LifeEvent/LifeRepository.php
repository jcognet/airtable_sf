<?php
declare(strict_types=1);

namespace App\Service\Repository\LifeEvent;

use App\Exception\LifeEvent\NoDataException;
use App\Exception\LifeEvent\WrongFormatException;
use App\Service\Security\FileEncoder;
use App\ValueObject\LifeEvent\Event;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LifeRepository
{
    private const FILE_NAME = 'life.bin';
    private const NONCE = '4701f5e94e7508b9213bbd4fd61d460675c2e3f01924305e';

    public function __construct(
        private readonly FileEncoder $fileEncoder,
        private readonly string $eventsPath,
        private readonly DenormalizerInterface $denormalizer,
        private readonly SerializerInterface $serializer,
    ) {}

    /**
     * @return Event[]
     */
    public function get(): array
    {
        $content = json_decode(
            $this->fileEncoder->decode(
                file_get_contents($this->getPath()),
                hex2bin(self::NONCE)
            ),
            true
        );

        if (!isset($content['data']['events'])) {
            throw new NoDataException();
        }

        $events = [];
        foreach ($content['data']['events'] as $event) {
            $events[] = $this->denormalizer->denormalize($event, Event::class);
        }

        return $events;
    }

    public function save(string $events): void
    {
        $fs = new Filesystem();
        $jsonDecoded = json_decode($events, true);

        if (!$jsonDecoded) {
            throw new WrongFormatException($events);
        }

        $data = $this->fileEncoder->encode(
            $this->serializer->serialize(
                [
                    'data' => [
                        'events' => $jsonDecoded,
                    ],
                    'metadata' => [
                        'created' => Carbon::now(),
                    ],
                ],
                'json'
            ),
            hex2bin(self::NONCE)
        );

        $fs->dumpFile(
            $this->getPath(),
            $data
        );
    }

    private function getPath(): string
    {
        return sprintf('%s%s', $this->eventsPath, self::FILE_NAME);
    }
}
