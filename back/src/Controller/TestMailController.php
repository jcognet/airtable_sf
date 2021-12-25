<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsletterManager\Manager;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestMailController extends AbstractController
{
    /**
     * @Route("/test/mail/show", name="test_mail_show", methods={"GET"})
     */
    public function show(
        Manager $newsHandler,
        Request $request
    ): Response
    {
        $date = Carbon::parse(  $request->query->get('date', null));

        return $this->render(
            'email/newsletter.html.twig',
            [
                'newspaper' => $newsHandler->createContent($date),
                'date'=>$date,
            ],
        );
    }
}
