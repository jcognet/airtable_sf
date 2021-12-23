<?php
declare(strict_types=1);

namespace App\ValueObject\Meteo;

use App\ValueObject\BlockInterface;

class MeteoList implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'list_meteo';
    /**
     * @var MeteoItem[]
     */
    private array $meteoItemLists;
    private string $latitude;
    private string $longitude;

    public function __construct(array $meteoItemLists, string $latitude, string $longitude)
    {
        $this->meteoItemLists = $meteoItemLists;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getTitle(): string
    {
        return 'Météo';
    }

    public function getContent()
    {
        return $this->getMeteoItemLists();
    }

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }

    public function getMeteoItemLists(): array
    {
        return $this->meteoItemLists;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
