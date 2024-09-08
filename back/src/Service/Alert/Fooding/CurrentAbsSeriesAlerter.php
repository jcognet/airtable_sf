<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Fooding\AbsSeriesCounter;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class CurrentAbsSeriesAlerter implements AlerterInterface
{
    private const THRESHOLD = 7;

    public function __construct(
        private readonly AbsSeriesCounter $absSeriesCounter
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        $countCurrentSerie = $this->absSeriesCounter->countCurrentSeries($date);

        if ($countCurrentSerie < self::THRESHOLD && !$forceReturnAlert) {
            return null;
        }

        return new Alert(
            message: sprintf(
                'Bravo, tu enchaînes %d jour%s avec abdo.',
                $countCurrentSerie,
                $countCurrentSerie > 1 ? 's' : ''
            ),
            lastDate: Carbon::now(),
            nbDays: $countCurrentSerie,
            level: LevelEnum::GOOD_NEWS,
            type: TypeEnum::ABS_CURRENT_SERIES
        );
    }
}
