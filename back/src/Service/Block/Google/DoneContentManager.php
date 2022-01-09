<?php
declare(strict_types=1);

namespace App\Service\Block\Google;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\ImageUrl;

class DoneContentManager implements BlockManagerInterface
{
    private string $doneContentUrl;

    public function __construct(string $doneContentUrl)
    {
        $this->doneContentUrl = $doneContentUrl;
    }

    public function getContent(): ?BlockInterface
    {
        return new ImageUrl(
            'Contenu fini',
            $this->doneContentUrl
        );
    }
}
