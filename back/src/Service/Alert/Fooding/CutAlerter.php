<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Service\Alert\AlerterInterface;
use App\Service\Import\Airtable\Fooding\Cut\Fetcher;
use App\ValueObject\Alert\Alert;
use App\ValueObject\Alert\LevelEnum;
use Carbon\Carbon;

class CutAlerter implements AlerterInterface
{
    private const ALERT_THRESHOLD = 14;

    public function __construct(
        private readonly Fetcher $fetcher
    ) {}

    public function getAlert(Carbon $date): ?Alert
    {
        $previousOccurence = $this->fetcher->getPreviousOccurence($date);

        if (!$previousOccurence) {
            return new Alert(
                message: 'Pas de coupe trouvée.',
                lastDate: Carbon::now(),
                nbDays: 0,
                level: LevelEnum::LOW
            );
        }

        $nbDays = $previousOccurence->getDate()->diff($date)->days;

        if ($nbDays < self::ALERT_THRESHOLD) {
            return null;
        }

        return new Alert(
            message: sprintf(
                'Pas de coupe depuis le %s (soit %d jours).',
                $previousOccurence->getDate()->format('d/m/Y'),
                $nbDays
            ),
            lastDate: $previousOccurence->getDate(),
            nbDays: $nbDays,
            level: LevelEnum::HIGH
        );
    }
}
