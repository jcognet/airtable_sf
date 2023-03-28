<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Lpo;

use App\ValueObject\Lpo\BlockBird;
use App\ValueObject\Lpo\ImportedBird;
use App\ValueObject\Picture\Picture;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BlockBirdDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): BlockBird
    {
        $data['bird'] = (new ImportedBirdDenormalizer())->denormalize($data['content'], ImportedBird::class, $format, $context);
        $data['image'] = (new ObjectNormalizer())->denormalize($data['image'], Picture::class, $format, $context);
        unset($data['title'], $data['content'], $data['class'], $data['type'], $data['managerTypeValue'], $data['managerType']);

        return new BlockBird(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === BlockBird::class;
    }
}
