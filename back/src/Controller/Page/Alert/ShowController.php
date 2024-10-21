<?php
declare(strict_types=1);

namespace App\Controller\Page\Alert;

use App\Service\Alert\Alerter;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route(path: '/alert/', name: 'alert_show', methods: ['GET'])]
    public function show(
        Request $request,
        Alerter $alerter
    ): Response {
        $date = Carbon::parse($request->query->get('date'));

        return $this->render(
            'alert/show.html.twig',
            [
                'head_title' => 'Alertes',
                'list_alerts' => $alerter->getListAlert($date, true),
            ]
        );
    }
}
