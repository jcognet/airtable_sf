<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Converter\ConvertBlockTypeToManagerType;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;
use App\ValueObject\Newspaper;
use Carbon\Carbon;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class NewspaperCreator implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly ConfigSelector $configSelector,
        private readonly ManagerContentFactory $managerContentFactory,
        private readonly string $environment,
        private readonly ConvertBlockTypeToManagerType $convertBlockTypeToManagerType
    ) {}

    public function createContent(Carbon $date): Newspaper
    {
        return $this->createNewsPaper(
            $this->configSelector->getBlocks($date),
            $date
        );
    }

    public function createAllContent(): Newspaper
    {
        return $this->createNewsPaper(
            $this->configSelector->getAllBlocks(),
            Carbon::now()
        );
    }

    public function createOneContent(string $type): Newspaper
    {
        return $this->createNewsPaper(
            [
                $this->convertBlockTypeToManagerType->convert(BlockType::make($type)),
            ],
            Carbon::now()
        );
    }

    /**
     * @param ManagerType[] $listManager
     */
    private function createNewsPaper(array $listManager, Carbon $date): Newspaper
    {
        $newspaper = new Newspaper($date);

        foreach ($listManager as $manager) {
            try {
                $newspaper->addBlock(
                    $this->managerContentFactory->getContent($manager->getType())
                );
            } catch (\Exception $e) {
                $this->logger->error(sprintf('Error with block %s: %s', $manager->getType(), $e->getMessage()), [
                    'exception' => [
                        'file' => $e->getFile(),
                        'code' => $e->getCode(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ],
                ]);

                if ($this->environment !== 'prod') {
                    throw $e;
                }
            }
        }

        return $newspaper;
    }
}
