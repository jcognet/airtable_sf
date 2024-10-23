<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use App\Service\Import\Airtable\AllImporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends AbstractController
{
    #[Route(path: '/import/all', name: 'import_all', methods: ['GET'])]
    public function index(
        AllImporter $importer,
    ): Response {
        $content = $importer->import();

        return new JsonResponse($content);
    }
}
