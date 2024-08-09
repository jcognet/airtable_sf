<?php
declare(strict_types=1);

namespace App\ValueObject\Alert;

class ListAlert
{
    /**
     * @param Alert[] $alerts
     */
    public function __construct(
        private readonly array $alerts
    ) {}

    public function getAlerts(): array
    {
        return $this->alerts;
    }

    public function hasAlerts(): bool
    {
        return $this->alerts !== [];
    }
}
