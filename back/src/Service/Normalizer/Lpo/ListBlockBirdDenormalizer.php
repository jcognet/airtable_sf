<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Lpo;

use App\ValueObject\Lpo\BlockBird;
use App\ValueObject\Lpo\ListBlockBird;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ListBlockBirdDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $birdDenormalizer = new BlockBirdDenormalizer();
        $birds = [];

        foreach ($data['content'] as $bird) {
            $birds[] = $birdDenormalizer->denormalize($bird, BlockBird::class);
        }

        unset($data['content']);
        $data['birds'] = $birds;

        return (new ObjectNormalizer())->denormalize($data, ListBlockBird::class);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === ListBlockBird::class;
    }
}
