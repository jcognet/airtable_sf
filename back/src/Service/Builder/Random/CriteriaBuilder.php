<?php
declare(strict_types=1);

namespace App\Service\Builder\Random;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Random\Criteria;

class CriteriaBuilder implements BuilderInterface
{
    public function build(array $data): Criteria
    {
        return new Criteria(
            $data['id'],
            $data['url'],
            $data['critere'],
            $data['thematique'],
            $data['objectif'],
            $data['miseEnOeuvre'],
            $data['controle']
        );
    }
}
