<?php
declare(strict_types=1);

namespace App\Service\Block\Google;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\ImageUrl;

class InProgressContentManager implements BlockManagerInterface
{
    public function __construct(private readonly string $progressContentUrl) {}

    public function getContent(): ?BlockInterface
    {
        return new ImageUrl(
            'En cours',
            $this->progressContentUrl
        );
    }
}
