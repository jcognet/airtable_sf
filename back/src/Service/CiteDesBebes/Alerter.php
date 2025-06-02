<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use App\Exception\CiteDesBebes\NoDataFoundForDateException;
use App\Service\Mailer\CiteDesBebesSender;
use Carbon\Carbon;

class Alerter
{
    public function __construct(
        private readonly SalesIsOpen $salesIsOpen,
        private readonly CiteDesBebesSender $sender
    ) {}

    public function alert(): bool
    {
        try {
            if (!$this->salesIsOpen->isInStock(Carbon::now()->addDays(7))) {
                return false;
            }
        } catch (NoDataFoundForDateException) {
            return false;
        }

        $this->sender->send();

        return true;
    }
}
