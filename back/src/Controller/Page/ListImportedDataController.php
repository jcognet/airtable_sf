<?php
declare(strict_types=1);

namespace App\Controller\Page;

use App\Service\Import\Airtable\ImportedDataFactory;
use App\Service\Import\Airtable\IsListable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListImportedDataController extends AbstractController
{
    #[Route(path: '/list_imported_data/{importedDataType}', name: 'list_imported_data_show', methods: ['GET'])]
    public function show(
        IsListable $isListable,
        string $importedDataType,
        ImportedDataFactory $importedDataFactory
    ): Response {
        $importedData = $importedDataFactory->make($importedDataType);

        return $this->render(
            'list_imported_data/show.html.twig',
            [
                'label' => $importedData->getLabel(),
                'fields' => $importedData->getFields(),
                'list_data' => $importedData->getData(),
                'type_listable' => $isListable->fetchAll(),
                'current_item' => $importedDataType,
            ]
        );
    }
}
