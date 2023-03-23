<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Inr;

use App\ValueObject\Inr\BlockFamille;
use App\ValueObject\Inr\Famille;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BlockFamilleDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): BlockFamille
    {
        return new BlockFamille(
            famille: (new FamilleDenormalizer())->denormalize($data['content'], Famille::class, $format, $context)
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === BlockFamille::class;
    }
}
