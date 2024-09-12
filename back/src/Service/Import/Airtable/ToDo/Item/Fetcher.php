<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\ToDo\Item;

class Fetcher
{
    public function __construct(private readonly Lister $lister) {}

    public function fetch(): ?array
    {
        return $this->lister->list();
    }
}
