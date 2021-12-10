<?php
declare(strict_types=1);

namespace App\Service\Builder\Biere;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Biere\Brasserie;

class BrasserieBuilder implements BuilderInterface
{
    public function build(array $data): Brasserie
    {
        return new Brasserie(
            $data['id'],
            $data['fields']['Name'] ?? null,
            $data['fields']['URL'] ?? null
        );
    }
}
