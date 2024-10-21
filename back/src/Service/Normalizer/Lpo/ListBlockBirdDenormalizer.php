<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Lpo;

use App\ValueObject\Lpo\BlockBird;
use App\ValueObject\Lpo\ListBlockBird;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ListBlockBirdDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ListBlockBird
    {
        $birdDenormalizer = new BlockBirdDenormalizer();
        $birds = [];

        foreach ($data['content'] as $bird) {
            $birds[] = $birdDenormalizer->denormalize($bird, BlockBird::class, $format, $context);
        }

        unset($data['content']);
        $data['birds'] = $birds;

        return (new ObjectNormalizer())->denormalize($data, ListBlockBird::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === ListBlockBird::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
