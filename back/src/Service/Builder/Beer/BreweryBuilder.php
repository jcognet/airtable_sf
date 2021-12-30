<?php
declare(strict_types=1);

namespace App\Service\Builder\Beer;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Beer\Brewery;

class BreweryBuilder implements BuilderInterface
{
    public function build(array $data): Brewery
    {
        return new Brewery(
            $data['id'],
            $data['fields']['Name'] ?? null,
            $data['fields']['URL'] ?? null
        );
    }
}
