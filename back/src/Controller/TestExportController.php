<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Export\ExportToSpreadsheet;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestExportController extends AbstractController
{
    /**
     * @Route("/test/export/show", name="test_export_show", methods={"GET"})
     */
    public function show(
        ExportToSpreadsheet $exportToSpreadsheet
    ): Response {
        return $this->render(
            'export/show.html.twig',
            [
                'data_exported' => $exportToSpreadsheet->getData()
            ],
        );
    }
}
