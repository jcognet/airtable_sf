<?php
declare(strict_types=1);

namespace App\ValueObject\Import\Airtable;

use App\Enum\Import\Airtable\Order;

class Sort
{
    public function __construct(
        private readonly ?string $property,
        private readonly ?Order $order,
    ) {}

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }
}
