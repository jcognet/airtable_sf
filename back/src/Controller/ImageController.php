<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Picture\ImageInPathLister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/img/list/", name="img_list", methods={"GET"})
     */
    public function list(
        Request $request,
        ImageInPathLister $imageInPathLister
    ): Response {
        if (!$request->query->has('directory')) {
            throw $this->createNotFoundException();
        }

        $directoryPath = $request->query->get('directory');

        try {
            $directory = $imageInPathLister->getPicturesFromDirectory($directoryPath);
        } catch (DirectoryNotFoundException $e) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'img/list.html.twig',
            [
                'directory' => $directory,
            ],
        );
    }
}
