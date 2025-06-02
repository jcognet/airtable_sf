<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use App\Exception\CiteDesBebes\NoDataFoundForDateException;
use Carbon\Carbon;

class SalesIsOpen
{
    public function __construct(private readonly Client $client) {}

    public function isInStock(Carbon $date): bool
    {
        $openSales = $this->client->fetch();

        foreach ($openSales as $sales) {
            $dateStart = new Carbon($sales['dateStart']);

            if ($dateStart->format('dmY') === $date->format('dmY')) {
                return $sales['isSalesOpen'] && $sales['isInStock'];
            }
        }

        throw new NoDataFoundForDateException($date, json_encode($openSales));
    }
}
