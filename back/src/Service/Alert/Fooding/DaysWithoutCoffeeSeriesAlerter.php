<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Fooding\CoffeeSeriesCounter;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class DaysWithoutCoffeeSeriesAlerter implements AlerterInterface
{
    private const THRESHOLD = 2;

    public function __construct(
        private readonly CoffeeSeriesCounter $coffeeSeriesCounter
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        $countCurrentSeriesWithout = $this->coffeeSeriesCounter->countCurrentSeriesWithout($date);

        if ($countCurrentSeriesWithout < self::THRESHOLD && !$forceReturnAlert) {
            return null;
        }

        return new Alert(
            message: sprintf(
                'Bravo, tu enchaînes %d jour%s sans café.',
                $countCurrentSeriesWithout,
                $countCurrentSeriesWithout > 1 ? 's' : ''
            ),
            lastDate: Carbon::now(),
            nbDays: $countCurrentSeriesWithout,
            level: LevelEnum::GOOD_NEWS,
            type: TypeEnum::COFFEE_CURRENT_WITHOUT_SERIES
        );
    }
}
