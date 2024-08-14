<?php
declare(strict_types=1);

namespace App\ValueObject\Alert;

class ListAlert
{
    private readonly array $alerts;

    /**
     * @param Alert[] $alerts
     */
    public function __construct(
        // alerts array has key (TypeEnum::value)
        array $alerts
    ) {
        usort($alerts, static fn (Alert $a, Alert $b) => $a->getType()->getLabel() <=> $b->getType()->getLabel());
        $this->alerts = $alerts;
    }

    public function getAlerts(): array
    {
        return $this->alerts;
    }

    public function hasAlerts(): bool
    {
        return $this->alerts !== [];
    }
}
