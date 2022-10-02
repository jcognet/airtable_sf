<?php
declare(strict_types=1);

namespace App\Service\Repository\Random;

use App\Service\Builder\Random\CatBuilder;
use App\ValueObject\BlockInterface;

class CatRepository implements RandomImageRepositoryInterface
{
    private const LIST = ['hangs in there', 'hello dude', 'Miaaaaaaouh !'];

    public function __construct(private readonly CatBuilder $catBuilder)
    {
    }

    public function fetchRandomData(array $param = []): BlockInterface
    {
        $text = self::LIST[array_rand(self::LIST)];

        return $this->catBuilder->build(['image' => sprintf('https://cataas.com/cat/says/%s?width=800', str_replace(' ', '%20', $text))]);
    }
}
