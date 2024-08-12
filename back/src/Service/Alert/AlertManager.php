<?php
declare(strict_types=1);

namespace App\Service\Alert;

use App\Service\Block\BlockManagerInterface as BlockManagerInterfaceAlias;
use App\ValueObject\BlockInterface;
use Carbon\Carbon;

class AlertManager implements BlockManagerInterfaceAlias
{
    public function __construct(private readonly Alerter $alerter) {}

    public function getContent(): ?BlockInterface
    {
        // Right now the managers don't handle a getContent with a date
        $listAlert = $this->alerter->getListAlert(Carbon::now());

        if (!$listAlert) {
            return null;
        }

        return new ListAlertBlock($listAlert);
    }
}
