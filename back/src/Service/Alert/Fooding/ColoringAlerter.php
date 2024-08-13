<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Service\Alert\AlerterInterface;
use App\Service\Import\Airtable\Fooding\Coloring\Fetcher;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class ColoringAlerter implements AlerterInterface
{
    private const ALERT_THRESHOLD = 14;
    private const NO_DATA_FOUND = 'Pas de couleur trouvée.';
    private const TEXT_PLACEHOLDER_ALERT = 'Pas de couleur depuis le %s (soit %d jours).';

    public function __construct(
        private readonly Fetcher $fetcher,
        private readonly AlertMaker $alertMaker
    ) {}

    public function getAlert(Carbon $date): ?Alert
    {
        return $this->alertMaker->make(
            $date,
            $this->fetcher,
            self::NO_DATA_FOUND,
            self::TEXT_PLACEHOLDER_ALERT,
            self::ALERT_THRESHOLD
        );
    }
}
