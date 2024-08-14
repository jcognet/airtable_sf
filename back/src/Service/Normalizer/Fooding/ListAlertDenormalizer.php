<?php
declare(strict_types=1);

namespace App\Service\Normalizer\Fooding;

use App\Service\Alert\ListAlertBlock;
use App\ValueObject\Alert\Alert;
use App\ValueObject\Alert\ListAlert;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ListAlertDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): ListAlertBlock
    {
        unset($data['title'], $data['content'], $data['class']);
        $alertDenormalize = new AlertDenormalizer();
        $alerts = [];

        if (isset($data['content']['alerts'])) {
            foreach ($data['content']['alerts'] as $alert) {
                $alerts[] = $alertDenormalize->denormalize($data['alert'], Alert::class);
            }
        }

        $data['listAlert'] = new ListAlert($alerts);

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
