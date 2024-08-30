<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Fooding\MeatSeriesCounter;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class DaysWithoutMeatSeriesAlerter implements AlerterInterface
{
    private const THRESHOLD = 3;

    public function __construct(
        private readonly MeatSeriesCounter $meatSeriesCounter
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        $countCurrentSeriesWithout = $this->meatSeriesCounter->countCurrentSeriesWithout($date);

        if ($countCurrentSeriesWithout < self::THRESHOLD && !$forceReturnAlert) {
            return null;
        }

        return new Alert(
            message: sprintf('Bravo, tu enchaînes %d jours sans viande.', $countCurrentSeriesWithout),
            lastDate: Carbon::now(),
            nbDays: $countCurrentSeriesWithout,
            level: LevelEnum::GOOD_NEWS,
            type: TypeEnum::MEAT_CURRENT_WITHOUT_SERIES
        );
    }
}
