<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\Service\AirTable\LastUsedManager;
use App\ValueObject\Article\Concept;
use App\ValueObject\Article\Image;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ConceptDenormalizer implements DenormalizerInterface
{
    public function __construct(private readonly LastUsedManager $lastUsedManager) {}

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Concept
    {
        $linkedContents = [];
        foreach ($data['linkedContents'] as $linkedContent) {
            $denormalizer = new ArticleDenormalizer();

            if ($linkedContent['class'] === Image::class) {
                $denormalizer = new ImageDenormalizer($this->lastUsedManager);
            }

            $linkedContents[] = $denormalizer->denormalize($linkedContent, $linkedContent['class'], $format, $context);
        }

        $data['linkedContents'] = $linkedContents;
        $data['name'] = $data['title'];
        $data['text'] = $data['content'];
        unset($data['title'], $data['content'], $data['class']);

        return $this->lastUsedManager->onPostDenormalize(Concept::class, $data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Concept::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
