<?php
declare(strict_types=1);

namespace App\Controller\Page;

use App\Enum\Import\Airtable\Order;
use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Exception\Import\Airtable\UnknownListServiceException;
use App\Service\Import\Airtable\ImportedDataFactory;
use App\Service\Import\Airtable\IsListable;
use App\ValueObject\Import\Airtable\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListImportedDataController extends AbstractController
{
    #[Route(path: '/list_imported_data/{importedDataType}', name: 'list_imported_data_show', methods: ['GET'])]
    public function show(
        IsListable $isListable,
        Request $request,
        string $importedDataType,
        ImportedDataFactory $importedDataFactory
    ): Response {
        $field = $request->query->get('sort_field', null);
        $order = Order::make($request->query->get('sort_order', null));
        $sort = ($field !== null) ? new Sort($field, $order) : null;

        try {
            $importedData = $importedDataFactory->make($importedDataType, $sort);
        } catch (UnknownDataImportedTypeException|UnknownListServiceException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->render(
            'list_imported_data/show.html.twig',
            [
                'label' => $importedData->getLabel(),
                'fields' => $importedData->getFields(),
                'list_data' => $importedData->getData(),
                'type_listable' => $isListable->fetchAll(),
                'current_item' => $importedDataType,
                'sort' => $sort,
            ]
        );
    }
}