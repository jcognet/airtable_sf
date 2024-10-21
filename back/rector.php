<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\ClassConstFetch\ClassOnThisVariableObjectRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Symfony62\Rector\Class_\MessageHandlerInterfaceToAttributeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // register a single rule
    $rectorConfig->symfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml');

    // @link https://github.com/rectorphp/rector/blob/main/docs/auto_import_names.md#auto-import-names
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        SetList::DEAD_CODE,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_63,
        SymfonySetList::SYMFONY_64,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ]);

    $rectorConfig->skip([
        ClassOnThisVariableObjectRector::class => [
            __DIR__ . '/src/ValueObject/AbstractBlock.php',
        ],
        MessageHandlerInterfaceToAttributeRector::class => [
            __DIR__ . '/src/ValueObject/AbstractBlock.php',
        ],
    ]);
};
