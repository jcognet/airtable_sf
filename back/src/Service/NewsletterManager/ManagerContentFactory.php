<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class ManagerContentFactory
{
    public function __construct(private readonly iterable $listManager) {}

    public function getContent(string $class): ?BlockInterface
    {
        /**
         * @var BlockManagerInterface $manager
         */
        foreach ($this->listManager as $manager) {
            if ($manager::class === $class) {
                $block = $manager->getContent();

                if ($block !== null) {
                    $block->setManagerType($class);
                }

                return $block;
            }
        }

        throw new \UnexpectedValueException(sprintf('Unknown class: %s', $class));
    }
}
