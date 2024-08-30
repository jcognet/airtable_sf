<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Fooding\AbsSeriesCounter;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class MaxAbsSeriesAlerter implements AlerterInterface
{
    public function __construct(
        private readonly AbsSeriesCounter $absSeriesCounter
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        // This alert only serves to get the max value
        if (!$forceReturnAlert) {
            return null;
        }

        $nbMaxSeries = $this->absSeriesCounter->countSeriesMax($date);

        return new Alert(
            message: sprintf('Bravo, ton record est de %d jours avec abdo.', $nbMaxSeries),
            lastDate: Carbon::now(),
            nbDays: $nbMaxSeries,
            level: LevelEnum::GOOD_NEWS,
            type: TypeEnum::ABS_MAX_SERIES,
        );
    }
}
