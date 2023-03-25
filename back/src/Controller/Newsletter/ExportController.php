<?php
declare(strict_types=1);

namespace App\Controller\Newsletter;

use App\Service\Export\ExportToSpreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportController extends AbstractController
{
    #[Route(path: '/newsletter/export/show', name: 'newsletter_export_show', methods: ['GET'])]
    public function show(
        ExportToSpreadsheet $exportToSpreadsheet
    ): Response {
        return $this->render(
            'export/show.html.twig',
            [
                'data_exported' => $exportToSpreadsheet->getData(),
            ],
        );
    }
}
