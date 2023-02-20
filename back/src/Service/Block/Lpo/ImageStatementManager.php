<?php
declare(strict_types=1);

namespace App\Service\Block\Lpo;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;
use App\ValueObject\Random\ImageUrl;
use App\ValueObject\Random\ListImageUrl;

class ImageStatementManager implements BlockManagerInterface
{
    public function __construct(private readonly string $absoluteUrlFront)
    {
    }

    public function getContent(): ?BlockInterface
    {
        return new ListImageUrl(
            'Décompte des oiseaux',
            [
                new ImageUrl(
                    'Page 1',
                    sprintf(
                        '%s%s',
                        $this->absoluteUrlFront,
                        'images/LPO_oiseau_fiche_p1.jpg'
                    ),
                    350
                ),
                new ImageUrl(
                    'Page 2',
                    sprintf(
                        '%s%s',
                        $this->absoluteUrlFront,
                        'images/LPO_oiseau_fiche_p2.jpg',
                    ),
                    350
                ),
            ]
        );
    }
}
