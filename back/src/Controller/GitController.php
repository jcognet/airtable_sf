<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Git\Deploy;
use App\Service\Git\TagHandler;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Attribute\Route;

class GitController extends AbstractController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    #[Route(path: '/git/deploy', name: 'git_deploy', methods: ['POST'])]
    public function deploy(
        Request $request,
        Deploy $deploy
    ): Response {
        if (!$deploy->checkAccess($request)) {
            $this->logger->error('Wrong header');
            throw $this->createNotFoundException('Wrong header');
        }

        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if ($content['repository']['name'] !== 'airtable_sf') {
            return new JsonResponse(sprintf('Failure: repository %s not handled.', $content['repository']['name']), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($content['ref_type'] !== 'tag') {
            return new JsonResponse(sprintf('Failure: type %s not handled.', $content['ref_type']), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deploy->deploy($content);

        return new JsonResponse('Success', Response::HTTP_OK);
    }

    #[Route(path: '/git/show', name: 'git_show', methods: ['GET'])]
    public function show(
        TagHandler $tagHandler
    ): Response {
        return new JsonResponse(
            [
                ...$tagHandler->get(),
                'Symfony_version' => Kernel::VERSION,
            ],
            Response::HTTP_OK
        );
    }
}
