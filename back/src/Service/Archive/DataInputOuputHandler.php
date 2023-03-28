<?php
declare(strict_types=1);

namespace App\Service\Archive;

use App\ValueObject\Archive\NewsLetter;
use App\ValueObject\Newspaper;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DataInputOuputHandler
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly DenormalizerInterface $denormalizer,
        private readonly DataIoHandler $dataIoHandler
    ) {
    }

    public function write(
        NewsLetter $newsLetter
    ): void {
        $this->dataIoHandler->write(
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
                [AbstractNormalizer::IGNORED_ATTRIBUTES => ['videoId']]
            ),
            $newsLetter->getDate()
        );
    }

    public function get(Carbon $date): ?NewsLetter
    {
        $data = $this->dataIoHandler->read($date);

        if ($data === null) {
            return null;
        }

        $newspaper = new Newspaper(
            date: $date
        );

        if (isset($data['data']['blocks'])) {
            foreach ($data['data']['blocks'] as $block) {
                $managerType = $block['managerType'];
                unset($block['type'], $block['managerTypeValue'], $block['managerType']);
                $block = $this->denormalizer->denormalize($block, $block['class']);
                $block->setManagerType($managerType['type']);
                $newspaper->addBlock($block);
            }
        }

        return new NewsLetter(
            date: Carbon::parse($data['metadata']['created']),
            newsletterHtml: $data['data']['newsletter_html'],
            wasSent: isset($data['metadata']['was_sent']) && (bool) $data['metadata']['was_sent'],
            newspaper: $newspaper
        );
    }
}
