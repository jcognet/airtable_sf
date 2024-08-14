<?php
declare(strict_types=1);

namespace App\Service\Alert\Fooding;

use App\Enum\Alert\LevelEnum;
use App\Enum\Alert\TypeEnum;
use App\Service\Alert\AlerterInterface;
use App\Service\Fooding\AbsMissingCounter;
use App\ValueObject\Alert\Alert;
use Carbon\Carbon;

class AbsAlerter implements AlerterInterface
{
    public function __construct(
        private readonly AbsMissingCounter $absMissingCounter
    ) {}

    public function getAlert(Carbon $date, bool $forceReturnAlert = false): ?Alert
    {
        $nbMissingAbs = $this->absMissingCounter->countMissingAbs($date);

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
            lastDate: $date,
            nbDays: $nbMissingAbs,
            level: LevelEnum::HIGH,
            type: TypeEnum::ABS,
        );
    }
}
