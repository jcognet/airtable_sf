<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Article;

use App\ValueObject\Article\Concept;
use App\ValueObject\Article\Image;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ConceptDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Concept
    {
        $linkedContents = [];
        foreach ($data['linkedContents'] as $linkedContent) {
            $denormalizer = new ArticleDenormalizer();

            if ($linkedContent['class'] === Image::class) {
                $denormalizer = new ImageDenormalizer();
            }

            $linkedContents[] = $denormalizer->denormalize($linkedContent, $linkedContent['class'], $format, $context);
        }

        $data['linkedContents'] = $linkedContents;
        $data['name'] = $data['title'];
        $data['text'] = $data['content'];
        unset($data['title'], $data['content'], $data['class']);

        return new Concept(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Concept::class;
    }
}
