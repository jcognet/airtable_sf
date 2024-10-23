<?php
declare(strict_types=1);

namespace App\Controller\Newsletter;

use Symfony\Component\Routing\Attribute\Route;
use App\Service\Export\Exporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends AbstractController
{
    #[Route(path: '/newsletter/export/show', name: 'newsletter_export_show', methods: ['GET'])]
    public function show(
        Exporter $exporter
    ): Response {
        return $this->render(
            'export/show.html.twig',
            [
                'data_exported' => $exporter->getData(),
            ],
        );
    }
}
