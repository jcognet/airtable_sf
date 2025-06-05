<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use App\Exception\CiteDesBebes\NoDataFoundForDateException;
use App\Service\Mailer\CiteDesBebesSender;
use App\ValueObject\CiteDesBebes\AvailibilitySales;
use Carbon\Carbon;

class Alerter
{
    public function __construct(
        private readonly SalesIsOpen $salesIsOpen,
        private readonly CiteDesBebesSender $sender,
        private readonly Fetcher $fetcher
    ) {}

    public function alert(): bool
    {
        try {
            $date = Carbon::now()->addDays(8);
            $sales = $this->fetcher->get($date);

            if (!$sales) {
                $sales = new AvailibilitySales(day: $date, start: Carbon::now(), stateHasChanged: true);
            }

            $sales->setIsSalesOpen(
                $this->salesIsOpen->isInStock($date)
            );

            $this->fetcher->write($sales);
        } catch (NoDataFoundForDateException) {
            return false;
        }

        if (!$sales->hasStateChanged()) {
            return false;
        }

        $this->sender->send($sales);

        return true;
    }
}
