<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Twitter;

use App\ValueObject\Twitter\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return new User(
            name: $data['name'],
            profileImageUrl: $data['profileImageUrl'],
            username: $data['username']
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === User::class;
    }
}
