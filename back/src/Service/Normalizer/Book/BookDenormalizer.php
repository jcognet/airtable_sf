<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Book;

use App\ValueObject\Book\Book;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BookDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Book
    {
        $data['body'] = $data['content'];
        unset($data['content'], $data['content'], $data['class'], $data['type'], $data['managerTypeValue'], $data['managerType']);

        return new Book(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Book::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
