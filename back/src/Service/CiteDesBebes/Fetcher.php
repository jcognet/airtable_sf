<?php
declare(strict_types=1);

namespace App\Service\CiteDesBebes;

use App\ValueObject\CiteDesBebes\AvailibilitySales;
use Carbon\Carbon;
use Symfony\Component\Serializer\SerializerInterface;

class Fetcher
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ReadWriteHandler $readWriteHandler
    ) {}

    public function write(
        AvailibilitySales $sales
    ): void {
        if (!$sales->hasStateChanged()) {
            return;
        }

        $listSales = $this->getAllSales();

        if ($listSales === null) {
            $listSales = [];
        }

        $this->readWriteHandler->write(
            $this->serializer->serialize(
                [
                    'data' => [
                        'sales' => [...$listSales, $sales],
                    ],
                    'metadata' => [
                        'updated' => Carbon::now(),
                    ],
                ],
                'json',
            ),
            Carbon::now()
        );
    }

    public function get(Carbon $date): ?AvailibilitySales
    {
        $listSales = $this->getAllSales();

        if ($listSales === null) {
            return null;
        }

        foreach ($listSales as $salesData) {
            $salesData['day'] = Carbon::parse($salesData['day']);
            $salesData['start'] = Carbon::parse($salesData['start']);
            $salesData['end'] = Carbon::parse($salesData['end']);
            $sales = new AvailibilitySales(
                ...$salesData
            );

            if ($sales->day->format('dmY') === $date->format('dmY')) {
                return $sales;
            }
        }

        return null;
    }

    /**
     * @return AvailibilitySales[]|null
     */
    public function list(): ?array
    {
        return $this->readWriteHandler->read(Carbon::now());
    }

    private function getAllSales(): ?array
    {
        $data = $this->readWriteHandler->read(Carbon::now());

        if ($data === null || !isset($data['data']['sales'])) {
            return null;
        }

        return $data['data']['sales'];
    }
}
