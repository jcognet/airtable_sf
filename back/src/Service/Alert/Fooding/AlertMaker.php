<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Service\Contract\PreviousOccurenceFetcherInterface;
use App\ValueObject\Alert\Alert;
use App\ValueObject\Alert\LevelEnum;
use Carbon\Carbon;

class AlertMaker
{
    public function make(
        Carbon $date,
        PreviousOccurenceFetcherInterface $fetcher,
        string $noDataFound,
        string $textPlaceholderAlert,
        int $threshold
    ): ?Alert {
        $previousOccurence = $fetcher->getPreviousOccurence($date);

        if (!$previousOccurence) {
            return new Alert(
                message: $noDataFound,
                lastDate: Carbon::now(),
                nbDays: 0,
                level: LevelEnum::LOW
            );
        }

        $nbDays = $previousOccurence->getDate()->diff($date)->days;

        if ($nbDays < $threshold) {
            return null;
        }

        return new Alert(
            message: sprintf(
                $textPlaceholderAlert,
                $previousOccurence->getDate()->format('d/m/Y'),
                $nbDays
            ),
            lastDate: $previousOccurence->getDate(),
            nbDays: $nbDays,
            level: LevelEnum::HIGH
        );
    }
}
