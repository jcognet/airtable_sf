<?php
declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PhpExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_class', $this->isClass(...)),
        ];
    }

    public function isClass($object, string $className): bool
    {
        return $object::class === $className;
    }
}
