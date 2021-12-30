<?php
declare(strict_types=1);

namespace App\Service\Builder\Beer;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Beer\BeerType;

class BeerTypeBuilder implements BuilderInterface
{
    public function build(array $data): BeerType
    {
        return new BeerType(
            $data['id'],
            $data['fields']['Name']
        );
    }
}
