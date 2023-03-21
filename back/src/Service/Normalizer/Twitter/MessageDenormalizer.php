<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Twitter;

use App\ValueObject\Twitter\Message;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MessageDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private readonly UserDenormalizer $userDenormalizer
    ) {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $data['user'] = $this->userDenormalizer->denormalize($data['user'], $type, $format, $context);
        unset($data['class']);

        return new Message(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Message::class;
    }
}
