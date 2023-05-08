<?php
declare(strict_types=1);

namespace App\Controller\Page\Question;

use App\Service\Import\Airtable\Qcm\Question\QuestionFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route(path: '/question/answer/{id}', name: 'question_answer', methods: ['GET'])]
    public function answer(
        Request $request,
        string $id,
        QuestionFetcher $questionFetcher
    ): Response {
        $answer = $request->query->get('answer', null);

        if ($answer === null) {
            throw $this->createNotFoundException('No answer is provided.');
        }

        $question = $questionFetcher->fetch($id);

        if ($question === null) {
            throw $this->createNotFoundException(sprintf('Wrong question provided: %s.', $id));
        }

        return $this->render(
            'question/answer.html.twig',
            [
                'question' => $question,
                'answer' => $answer,
            ]
        );
    }
}
