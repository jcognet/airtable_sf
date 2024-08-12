<?php
declare(strict_types=1);

namespace App\Service\Alert;

use App\ValueObject\Alert\Alert;
use App\ValueObject\Alert\ListAlert;
use Carbon\Carbon;

class Alerter
{
    /**
     * @var Alert[]
     */
    private ?array $alerts = [];

    /**
     * @param AlerterInterface[] $alerters
     */
    public function __construct(private readonly iterable $alerters) {}

    /**
     * @return Alert[]|null
     */
    public function getListAlert(Carbon $date): ?ListAlert
    {
        $key = $date->format('dmY');
        if (isset($this->alerts[$key])) {
            return $this->alerts[$key];
        }

        $this->alerts[$key] = null;
        $listAlerts = [];
        foreach ($this->alerters as $alerter) {
            $alert = $alerter->getAlert($date);

            if ($alert) {
                $listAlerts[] = $alert;
            }
        }

        if ($listAlerts) {
            $this->alerts[$key] = new ListAlert($listAlerts);
        }

        return $this->alerts[$key];
    }
}
