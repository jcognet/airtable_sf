<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\Service\Alert\ListAlertBlock;
use App\ValueObject\Alert\ListAlert;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ListAlertDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): ListAlertBlock
    {
        $data['listAlert'] = new ListAlert($data['content']['alerts']);
        unset($data['title'], $data['content'], $data['class']);

        return new ListAlertBlock(...$data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === ListAlertBlock::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
