<?php
declare(strict_types=1);

namespace App\Service\Archive;

use App\ValueObject\Archive\NewsLetter;
use App\ValueObject\Newspaper;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DataInputOuputHandler
{
    public function __construct(
        private readonly string $deployArchiveJsonPath,
        private readonly SerializerInterface $serializer,
        private readonly DenormalizerInterface $denormalizer
    ) {
    }

    public function write(
        NewsLetter $newsLetter
    ): void {
        $fs = new Filesystem();

        $fs->dumpFile(
            $this->getFileName($newsLetter->getDate()),
            $this->serializer->serialize(
                [
                    'data' => [
                        'newsletter_html' => $newsLetter->getNewsletterHtml(),
                        'blocks' => $newsLetter->getNewspaper()->getBlocks(),
                    ],
                    'metadata' => [
                        'created' => $newsLetter->getDate(),
                        'was_sent' => $newsLetter->wasSent(),
                    ],
                ],
                'json',
                [AbstractNormalizer::IGNORED_ATTRIBUTES => ['managerType', 'managerTypeValue', 'type', 'videoId']]
            )
        );
    }

    public function get(Carbon $date): ?NewsLetter
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->getFileName($date))) {
            return null;
        }

        $data = json_decode(
            file_get_contents(
                $this->getFileName($date)
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $newspaper = new Newspaper(
            date: $date
        );

        if (isset($data['data']['blocks'])) {
            foreach ($data['data']['blocks'] as $block) {
                $newspaper->addBlock(
                    $this->denormalizer->denormalize($block, $block['class'])
                );
            }
        }

        return new NewsLetter(
            date: Carbon::parse($data['metadata']['created']),
            newsletterHtml: $data['data']['newsletter_html'],
            wasSent: isset($data['metadata']['was_sent']) && (bool) $data['metadata']['was_sent'],
            newspaper: $newspaper
        );
    }

    protected function getFileName(Carbon $date): string
    {
        return sprintf('%s/%s_newsletter.json', $this->deployArchiveJsonPath, $date->format('Y-m-d'));
    }
}
