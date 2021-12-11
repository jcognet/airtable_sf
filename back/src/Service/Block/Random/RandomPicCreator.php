<?php
declare(strict_types=1);

namespace App\Service\Block\Random;

use App\Service\Block\CreatorInterface;
use App\Service\Repository\Random\CatRepository;
use App\Service\Repository\Random\FoxRepository;
use App\Service\Repository\Random\StarRepository;
use App\ValueObject\BlockInterface;

class RandomPicCreator implements CreatorInterface
{
    private const LIST = ['cat', 'fox', 'star'];

    private CatRepository $catRepository;
    private FoxRepository $foxRepository;
    private StarRepository $starRepository;

    public function __construct(
        CatRepository $catRepository,
        FoxRepository $foxRepository,
        StarRepository $starRepository
    ) {
        $this->catRepository = $catRepository;
        $this->foxRepository = $foxRepository;
        $this->starRepository = $starRepository;
    }

    public function getContent(): BlockInterface
    {
        $rand = array_rand(self::LIST);

        $repository = self::LIST[$rand] . 'Repository';

        return $this->{$repository}->fetchRandomData();
    }
}
