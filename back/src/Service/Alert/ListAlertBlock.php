<?php
declare(strict_types=1);

namespace App\Service\Alert;

use App\ValueObject\AbstractBlock;
use App\ValueObject\Alert\ListAlert;
use App\ValueObject\NewsletterBlockManager\BlockType;

class ListAlertBlock extends AbstractBlock
{
    public function __construct(private readonly ListAlert $listAlert) {}

    public function getTitle(): string
    {
        return 'Alertes';
    }

    public function getContent()
    {
        return $this->listAlert;
    }

    public function getType(): BlockType
    {
        return BlockType::LIST_ALERT;
    }
}
