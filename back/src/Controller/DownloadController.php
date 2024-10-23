<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use App\Service\Picture\EncoderDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\MimeTypes;

class DownloadController extends AbstractController
{
    #[Route(path: '/file/download/${pathFile}', name: 'file_download', methods: ['GET'])]
    public function list(
        EncoderDecoder $encoderDecoder,
        string $pathFile
    ): Response {
        $file = $encoderDecoder->decode($pathFile);

        if (!is_file($file)) {
            throw $this->createNotFoundException(sprintf('Unknown file: %s', $file));
        }

        $mimeTypes = new MimeTypes();

        return new BinaryFileResponse(
            $file,
            headers: ['Content-Type' => $mimeTypes->getMimeTypes($file)],
            contentDisposition: ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        );
    }
}
