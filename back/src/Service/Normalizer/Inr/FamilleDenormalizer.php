<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Inr;

use App\ValueObject\Inr\Famille;
use App\ValueObject\Inr\Inr491Recommandation;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FamilleDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $inr491RecommandationDenormalizer = new Inr491RecommandationDenormalizer();
        $randomContent = $data['randomContent'];
        unset($data['randomContent']);
        $famille = new Famille(...$data);
        $famille->setRandomContent($inr491RecommandationDenormalizer->denormalize($randomContent, Inr491Recommandation::class));

        return $famille;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return $type === Famille::class;
    }
}
