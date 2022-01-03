<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Block\BlockManagerInterface;
use App\ValueObject\BlockInterface;

class ManagerContentFactory
{
    private $listManager = [];

    public function __construct(
        iterable $blockManagers
    ) {
        $this->listManager = $blockManagers;
    }

    public function getContent(string $class): ?BlockInterface
    {
        /**
         * @var BlockManagerInterface $manager
         */
        foreach ($this->listManager as $manager) {
            if (get_class($manager) === $class) {
                return $manager->getContent();
            }
        }

        throw new \UnexpectedValueException(sprintf('Unknown class: %s', $class));
    }
}
