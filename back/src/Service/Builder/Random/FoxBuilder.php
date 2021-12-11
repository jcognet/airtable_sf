<?php
declare(strict_types=1);

namespace App\Service\Builder\Random;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Random\Url;

class FoxBuilder implements BuilderInterface
{
    public function build(array $data)
    {
        return new Url(
            'renard',
            $data['image']
        );
    }
}
