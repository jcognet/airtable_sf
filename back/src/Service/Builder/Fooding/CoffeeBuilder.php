<?php
declare(strict_types=1);

namespace App\Service\Builder\Fooding;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Fooding\Coffee;
use Carbon\Carbon;

class CoffeeBuilder implements BuilderInterface
{
    public function build(array $data): ?Coffee
    {
        if (!isset($data['fields']['Jour']) && $data['fields']['Quantité']) {
            return null;
        }

        return new Coffee(
            date: Carbon::parse($data['fields']['Jour']),
            quantity: $data['fields']['Quantité'],
            comment: $data['fields']['Commentaire'] ?? null,
        );
    }
}
