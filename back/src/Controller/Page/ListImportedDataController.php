<?php
declare(strict_types=1);

namespace App\Controller\Page;

use App\Enum\Import\Airtable\Order;
use App\Exception\Import\Airtable\UnknownDataImportedTypeException;
use App\Exception\Import\Airtable\UnknownListServiceException;
use App\Service\Import\Airtable\Factory\ImportedDataFactory;
use App\Service\Import\Airtable\IsFiltrable;
use App\Service\Import\Airtable\IsListable;
use App\ValueObject\Import\Airtable\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListImportedDataController extends AbstractController
{
    #[Route(path: '/list_imported_data/{importedDataType}', name: 'list_imported_data_show', methods: ['GET'])]
    public function show(
        IsListable $isListable,
        IsFiltrable $isFiltrable,
        Request $request,
        string $importedDataType,
        ImportedDataFactory $importedDataFactory
    ): Response {
        $field = $request->query->get('sort_field', null);
        $filter = $request->query->get('filter', null);
        $order = Order::make($request->query->get('sort_order', null));
        $sort = ($field !== null) ? new Sort($field, $order) : null;

        try {
            $importedData = $importedDataFactory->make($importedDataType, $sort, $filter);
        } catch (UnknownDataImportedTypeException|UnknownListServiceException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $template = filter_var($request->query->get('fetch', null), FILTER_VALIDATE_BOOLEAN)
            ? 'list_imported_data/include/data_table.html.twig' :
            'list_imported_data/show.html.twig';

        return $this->render(
            $template,
            [
                'label' => $importedData->getLabel(),
                'fields' => $importedData->getFields(),
                'list_data' => $importedData->getData(),
                'type_listable' => $isListable->fetchAll(),
                'current_item' => $importedDataType,
                'sort' => $sort,
                'head_title' => sprintf('Données importées : %s', $importedData->getLabel()),
                'is_filtrable' => $isFiltrable->isFiltrable($importedDataType),
                'filter' => $filter,
            ]
        );
    }

    #[Route(path: '/list_imported_data/{importedDataType}', name: 'list_imported_data_handle_form', methods: ['POST'])]
    public function handleForm(
        Request $request,
        string $importedDataType,
    ): Response {
        return $this->redirectToRoute(
            'list_imported_data_show',
            [
                ...$request->query->all(),
                'importedDataType' => $importedDataType,
                'filter' => $request->request->get('filter', null), // Comprendre pourquoi il n'y a rien qui est posté
            ],
        );
    }
}
