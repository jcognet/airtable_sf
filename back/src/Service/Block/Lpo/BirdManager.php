<?php
declare(strict_types=1);

namespace App\Service\Block\Lpo;

use App\Service\Block\BlockManagerInterface;
use App\Service\Lpo\BirdLister;
use App\Service\Picture\PictureFactory;
use App\ValueObject\BlockInterface;
use App\ValueObject\Lpo\BlockBird;

class BirdManager implements BlockManagerInterface
{
    public function __construct(
        private readonly BirdLister $birdLister,
        private readonly PictureFactory $pictureFactory
    ) {
    }

    public function getContent(): ?BlockInterface
    {
        $birds = $this->birdLister->list(true);

        if (count((array) $birds) === 0) {
            return null;
        }

        $key = array_rand($birds);
        $bird = $birds[$key];

        return new BlockBird(
            $bird,
            $this->pictureFactory->get($bird->getSavedImgPath())
        );
    }
}
