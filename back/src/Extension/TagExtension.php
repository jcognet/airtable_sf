<?php
declare(strict_types=1);

namespace App\Extension;

use App\Service\Git\TagReader;
use Carbon\Carbon;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TagExtension extends AbstractExtension
{
    public function __construct(private readonly TagReader $tagReader)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_last_deploy', $this->getLastDeploy(...)),
            new TwigFunction('get_last_tag', $this->getLastTag(...)),
        ];
    }

    public function getLastDeploy(): Carbon
    {
        return $this->tagReader->getLastDeploy();
    }

    public function getLastTag(): string
    {
        return $this->tagReader->getLastTag();
    }
}
