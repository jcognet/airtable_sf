<?php
declare(strict_types=1);

namespace App\Service\Builder\Random;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Random\Criteria;

class CriteriaBuilder implements BuilderInterface
{
    public function build(array $data): Criteria
    {
        $jobs = $data['metiers'];

        if (!is_array($jobs)) {
            $jobs = [$jobs];
        }

        return new Criteria(
            $data['id'],
            $data['critere'],
            $data['thematique'],
            $data['objectif'],
            $data['miseEnOeuvre'],
            $data['controle'],
            $data['difficulte'],
            $data['priorite'] ?? null,
            $data['application'],
            $jobs
        );
    }
}
