<?php
declare(strict_types=1);

namespace App\Service\Normalizer\ToDo;

use App\ValueObject\ToDo\Item;
use App\ValueObject\ToDo\ItemList;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ItemListDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ItemList
    {
        $itemLists = [];
        $denormalizer = new ItemDenormalizer();

        foreach ($data['content'] as $key => $item) {
            $itemLists[$key] = $denormalizer->denormalize($item, Item::class, $format, $context);
        }

        $data['toDos'] = $itemLists;

        return (new ObjectNormalizer())->denormalize($data, ItemList::class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === ItemList::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
