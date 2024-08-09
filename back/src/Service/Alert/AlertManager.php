<?php
declare(strict_types=1);

namespace App\Service\Alert;

use App\Service\Block\BlockManagerInterface as BlockManagerInterfaceAlias;
use App\ValueObject\BlockInterface;

class AlertManager implements BlockManagerInterfaceAlias
{
    public function __construct(private readonly Alerter $alerter) {}

    public function getContent(): ?BlockInterface
    {
        $listAlert = $this->alerter->getListAlert();

        if (!$listAlert) {
            return null;
        }

        return new ListAlertBlock($listAlert);
    }
}
