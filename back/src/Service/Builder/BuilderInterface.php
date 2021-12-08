<?php
declare(strict_types=1);

namespace App\Service\Builder;

interface BuilderInterface
{
    public function build(array $data);
}
