<?php
declare(strict_types=1);

namespace App\ValueObject\Alert\ExtraData;

class AbsSeries extends AbstractExtraData
{
    private const LABEL = 'Bravo ! Tu es à %d jours d\'affilé ! ';

    public function __construct(private readonly int $nbDay) {}

    public function getLabel(): string
    {
        return sprintf(self::LABEL, $this->nbDay);
    }
}
