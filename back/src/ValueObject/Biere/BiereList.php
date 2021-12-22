<?php
declare(strict_types=1);

namespace App\ValueObject\Biere;

use App\ValueObject\BlockInterface;

class BiereList implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'list_biere';

    private ?string $title;
    /**
     * @var Biere[]
     */
    private array $bieres;

    public function __construct(
        string $title,
        array $bieres
    ) {
        $this->title = $title;
        $this->bieres = $bieres;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->bieres;
    }

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }
}
