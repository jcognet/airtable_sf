<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Import\Airtable\Fooding\Qi\Fetcher;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class QiAlerter implements AlerterInterface
{
    private const ALERT_THRESHOLD = 7;
    private const NO_DATA_FOUND = 'Pas de qi trouvée.';
    private const TEXT_PLACEHOLDER_ALERT = 'Pas de qi depuis le %s (soit %d jours).';

    public function __construct(
        private readonly Fetcher $fetcher,
        private readonly AlertMaker $alertMaker
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        return $this->alertMaker->make(
            $date,
            $this->fetcher,
            self::NO_DATA_FOUND,
            self::TEXT_PLACEHOLDER_ALERT,
            self::ALERT_THRESHOLD,
            TypeEnum::QI,
            $forceReturnAlert
        );
    }
}
