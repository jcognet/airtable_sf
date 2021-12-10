<?php
declare(strict_types=1);

namespace App\Service\Builder\Biere;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Biere\BiereType;

class BiereTypeBuilder implements BuilderInterface
{
    public function build(array $data): BiereType
    {
        return new BiereType(
            $data['id'],
            $data['fields']['Name']
        );
    }
}
