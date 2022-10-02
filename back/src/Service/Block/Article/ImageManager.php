<?php
declare(strict_types=1);

namespace App\Service\Block\Article;

use App\Service\AirTable\Article\ImageClient;
use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class ImageManager implements BlockManagerInterface
{
    public function __construct(private readonly ImageClient $imageClient)
    {
    }

    public function getContent(): ?BlockInterface
    {
        return $this->imageClient->fetchRandomData();
    }
}
