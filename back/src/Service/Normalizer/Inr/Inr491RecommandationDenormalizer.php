<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Inr;

use App\ValueObject\Inr\Inr491Item;
use App\ValueObject\Inr\Inr491Recommandation;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Inr491RecommandationDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $itemDenormalizer = new Inr491ItemDenormalizer();
        $items = [];

        foreach ($data['items'] as $item) {
            $items[] = $itemDenormalizer->denormalize($item, Inr491Item::class);
        }

        unset($data['items']);

        $recommandation = new Inr491Recommandation(...$data);

        foreach ($items as $item) {
            $recommandation->addItem($item);
        }

        return $recommandation;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Inr491Recommandation::class;
    }
}
