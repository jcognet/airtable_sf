<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Official;

use App\ValueObject\Official\Passport;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PassportDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Passport
    {
        $data['url'] = $data['content'];
        unset($data['content'], $data['class'], $data['title']);

        return new Passport(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Passport::class;
    }
}
