<?php
declare(strict_types=1);

namespace App\Service\Builder\Fooding;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Fooding\Qi;
use Carbon\Carbon;

class QiBuilder implements BuilderInterface
{
    public function build(array $data): ?Qi
    {
        if (!isset($data['fields']['Jour'])) {
            return null;
        }

        return new Qi(
            date: Carbon::parse($data['fields']['Jour']),
            comment: $data['fields']['Commentaire'] ?? null
        );
    }
}
