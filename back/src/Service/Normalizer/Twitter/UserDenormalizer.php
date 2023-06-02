<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Twitter;

use App\ValueObject\Twitter\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): User
    {
        return new User(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === User::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
