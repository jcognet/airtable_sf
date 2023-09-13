<?php
declare(strict_types=1);

namespace App\Service\Builder\Random;

use App\Service\Builder\BuilderInterface;
use App\ValueObject\Random\GoodPractice;

class GoodPracticeBuilder implements BuilderInterface
{
    public function build(array $data): GoodPractice
    {
        return new GoodPractice(
            $data['id'],
            $data['priorite'],
            $data['difficulte'],
            $data['indicateurs'],
            $data['url'],
            $data['titre']
        );
    }
}
