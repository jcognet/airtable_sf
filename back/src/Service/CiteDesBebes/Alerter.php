<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use App\Exception\CiteDesBebes\NoDataFoundForDateException;
use App\Service\Mailer\CiteDesBebesSender;
use App\ValueObject\CiteDesBebes\AvailibilitySales;
use Carbon\Carbon;

class Alerter
{
    private const NB_TO_CHECK = 8;

    public function __construct(
        private readonly SalesIsOpen $salesIsOpen,
        private readonly CiteDesBebesSender $sender,
        private readonly Fetcher $fetcher
    ) {}

    public function alert(): bool
    {
        try {
            $date = Carbon::now()->addDays(self::NB_TO_CHECK);
            $sales = $this->fetcher->get($date);

            // No sales found, what about the sales in 7 days ? Did this sales is finished ?
            // (case: we still query the API early morning before the sales is over)
            if (!$sales) {
                $date = Carbon::now()->addDays(self::NB_TO_CHECK - 1);
                $sales = $this->fetcher->get($date);

                // Still no sales or the sales is not open => we create a new one
                if (!$sales || !$sales->isSalesOpen()) {
                    $date = Carbon::now()->addDays(self::NB_TO_CHECK);
                    $sales = new AvailibilitySales(day: $date, start: Carbon::now(), stateHasChanged: true);
                }
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
