<?php
declare(strict_types=1);

namespace App\Service\Contract;

interface AirtableConfigInterface
{
    public function getSubPath(): string;

    public function getFileName(): string;

    public function getCompleteName(): string;

    public function getDataEntryName(): string;

    public function getClass(): string;

    public function getPublicKey(): string;

    public function getPublicLabel(): string;
}
