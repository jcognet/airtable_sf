<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Fooding\AbsMissingCounter;
use App\Service\Import\Airtable\Fooding\Abs\Fetcher;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class AbsAlerter implements AlerterInterface
{
    public function __construct(
        private readonly AbsMissingCounter $absMissingCounter,
        private readonly Fetcher $fetcher
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        $nbMissingAbs = $this->absMissingCounter->countMissingAbs($date);
        $previousOccurence = $this->fetcher->getPreviousOccurence($date);

        if ($nbMissingAbs === null) {
            return new Alert(
                message: 'Pas de gainage trouvé.',
                lastDate: Carbon::now(),
                nbDays: 0,
                level: LevelEnum::LOW,
                type: TypeEnum::ABS,
            );
        }

        if ($nbMissingAbs === 0 && !$forceReturnAlert) {
            return null;
        }

        $message = sprintf(
            'Attention, il manque %d gainage',
            $nbMissingAbs
        );

        if ($nbMissingAbs > 1) {
            $message .= 's';
        }

        $message .= '.';

        return new Alert(
            message: $message,
            lastDate: $previousOccurence->getDate(),
            nbDays: $nbMissingAbs,
            level: LevelEnum::HIGH,
            type: TypeEnum::ABS,
            extraData: $this->getExtraData()
        );
    }

    private function getExtraData(): ?array
    {
        return null;
    }
}
