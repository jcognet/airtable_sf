<?php
declare(strict_types=1);

namespace App\Service\Lpo;

class Config
{
    public function __construct(
        private readonly string $birdPath
    ) {
    }

    public function getSavedBirdFileName(): string
    {
        return sprintf('%s%s', $this->birdPath, 'birds.json');
    }
}
