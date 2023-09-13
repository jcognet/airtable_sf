<?php
declare(strict_types=1);

namespace App\Service\Holiday;

use App\Service\Import\Airtable\Holiday\Holiday\Fetcher;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\RequestStack;

class IsHolidayDeterminator
{
    private const HOLIDAY_GET_KEYWORD = 'holiday';
    private const HOLIDAY_GET_KEYWORD_FORCE_FALSE = 'false';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Fetcher $fetcher
    ) {}

    public function isHoliday(?Carbon $date): bool
    {
        if (
            $this->requestStack->getMainRequest() !== null
            && $this->requestStack->getMainRequest()->query->has(self::HOLIDAY_GET_KEYWORD)
        ) {
            return $this->requestStack->getMainRequest()->query->get(self::HOLIDAY_GET_KEYWORD) !== self::HOLIDAY_GET_KEYWORD_FORCE_FALSE;
        }

        if ($date === null) {
            $date = Carbon::now();
        }

        $holidays = $this->fetcher->fetchFromDate($date);

        if ($holidays === null) {
            return false;
        }

        return count($holidays) > 0;
    }
}
