<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Git\Deploy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GitController extends AbstractController
{
    /**
     * @Route("/git/deploy/", name="git_deploy", methods={"POST"})
     */
    public function deploy(
        Request $request,
        Deploy $deploy
    ): Response {
        $content = json_decode($request->getContent(), true);

        if ($content['repository'] !== 'airtable_sf') {
            return new JsonResponse(sprintf('Failure: repository %s not handled.', $content['repository']), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($content['ref_type'] !== 'tag') {
            return new JsonResponse(sprintf('Failure: type %s not handled.', $content['ref_type']), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deploy->deploy($content);

        return new JsonResponse('Success', Response::HTTP_OK);
    }
}
