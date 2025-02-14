<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Contract\PreviousOccurrenceFetcherInterface;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class AlertMaker
{
    public function make(
        Carbon $date,
        PreviousOccurrenceFetcherInterface $fetcher,
        string $noDataFound,
        string $textPlaceholderAlert,
        int $threshold,
        TypeEnum $type,
        bool $forceReturnAlert = false,
    ): ?Alert {
        $previousOccurence = $fetcher->getPreviousOccurrence($date);

        if (!$previousOccurence) {
            return new Alert(
                message: $noDataFound,
                lastDate: Carbon::now(),
                nbDays: 0,
                level: LevelEnum::LOW,
                type: $type
            );
        }

        $nbDays = (int) $previousOccurence->getDate()->diffInDays($date);

        if ($nbDays < $threshold && !$forceReturnAlert) {
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
            level: LevelEnum::HIGH,
            type: $type
        );
    }
}
