<?php
declare(strict_types=1);

namespace App\ValueObject\Random;

use App\ValueObject\BlockInterface;

class Url implements BlockInterface
{
    private const BLOCK_INTERFACE_TYPE = 'url';

    private string $title;
    private string $url;

    public function __construct(string $title, string $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->url;
    }

    public function getType(): string
    {
        return self::BLOCK_INTERFACE_TYPE;
    }
}
