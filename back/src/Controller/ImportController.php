<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Import\Airtable\AllImporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route(path: '/import/all', name: 'import_all', methods: ['GET'])]
    public function index(
        AllImporter $importer,
    ): Response {
        $content = $importer->import();

        return new JsonResponse($content);
    }
}
