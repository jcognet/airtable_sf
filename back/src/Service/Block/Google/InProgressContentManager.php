<?php
declare(strict_types=1);

namespace App\Service\Block\Google;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\ImageUrl;

class InProgressContentManager implements BlockManagerInterface
{
    private string $progressContentUrl;

    public function __construct(string $progressContentUrl)
    {
        $this->progressContentUrl = $progressContentUrl;
    }

    public function getContent(): ?BlockInterface
    {
        return new ImageUrl(
            'En courss',
            $this->progressContentUrl
        );
    }
}
