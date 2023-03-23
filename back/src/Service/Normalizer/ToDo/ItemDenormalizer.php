<?php
declare(strict_types=1);

namespace App\Service\Normalizer\ToDo;

use App\ValueObject\ToDo\Item;
use Carbon\Carbon;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ItemDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Item
    {
        $data['createdAt'] = Carbon::parse($data['createdAt']);

        if (isset($data['dueAt'])) {
            $data['dueAt'] = Carbon::parse($data['dueAt']);
        }

        $data['isImportant'] = $data['important'];
        unset($data['important']);

        return new Item(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Item::class;
    }
}
