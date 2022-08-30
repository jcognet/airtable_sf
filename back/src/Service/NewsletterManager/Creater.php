<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Converter\ConvertBlockTypeToManagerType;
use App\Service\Mailer\NewspaperSender;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;
use App\ValueObject\Newspaper;
use Carbon\Carbon;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Twig\Environment;

class Creater implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private NewspaperSender $sender;
    private ConfigSelector $configSelector;
    private ManagerContentFactory $managerContentFactory;
    private string $environment;
    private ConvertBlockTypeToManagerType $convertBlockTypeToManagerType;
    private Environment $twig;

    private Newspaper $newspaper;
    private $html;

    public function __construct(
        NewspaperSender $sender,
        ConfigSelector $configSelector,
        ManagerContentFactory $managerContentFactory,
        string $environment,
        ConvertBlockTypeToManagerType $convertBlockTypeToManagerType,
        Environment $twig
    ) {
        $this->sender = $sender;
        $this->configSelector = $configSelector;
        $this->managerContentFactory = $managerContentFactory;
        $this->environment = $environment;
        $this->convertBlockTypeToManagerType = $convertBlockTypeToManagerType;
        $this->twig = $twig;
    }

    public function handle(Carbon $date): void
    {
        $this->createContent($date);
        $this->sendContent();
    }

    public function getHtml(bool $showBlock = false): string
    {
        if ($this->html === null) {
            $this->html = $this->twig->render(
                'email/newsletter.html.twig',
                [
                    'newspaper' => $this->newspaper,
                    'date' => $this->newspaper->getDate(),
                    'show_block' => $showBlock,
                ]
            );
        }

        return $this->html;
    }

    public function createContent(Carbon $date): void
    {
        $this->createNewsPaper($this->configSelector->getBlocks($date), $date);
    }

    public function createAllContent(): void
    {
        $this->createNewsPaper($this->configSelector->getAllBlocks(), Carbon::now());
    }

    public function createOneContent(string $type): void
    {
        $this->createNewsPaper([
            $this->convertBlockTypeToManagerType->convert(new BlockType($type)),
        ], Carbon::now());
    }

    private function sendContent(): void
    {
        $this->sender->send(
            $this->getHtml(),
        );
    }

    /**
     * @param ManagerType[] $listManager
     */
    private function createNewsPaper(array $listManager, Carbon $date): void
    {
        $this->newspaper = new Newspaper($date);

        foreach ($listManager as $manager) {
            try {
                $this->newspaper->addBlock($this->managerContentFactory->getContent($manager->getType()));
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
    }
}
