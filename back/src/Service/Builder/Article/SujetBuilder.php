<?php
declare(strict_types=1);

namespace App\Service\Builder\Article;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Article\Sujet;

class SujetBuilder implements BuilderInterface
{
    public function build(array $data): Sujet
    {
        return new Sujet(
            $data['id'],
            $data['fields']['Sujet']
        );
    }
}
