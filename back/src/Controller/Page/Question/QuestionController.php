<?php
declare(strict_types=1);

namespace App\Controller\Page\Question;

use App\Service\Block\Question\QuestionManager;
use App\Service\Import\Airtable\Qcm\Question\Fetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route(path: '/question/answer/{id}', name: 'question_answer', methods: ['GET'])]
    public function answer(
        Request $request,
        string $id,
        Fetcher $questionFetcher
    ): Response {
        $answer = $request->query->get('answer', null);
        $question = $questionFetcher->fetch($id);

        if ($question === null) {
            throw $this->createNotFoundException(sprintf('Wrong question provided: %s.', $id));
        }

        $showAnswer = $answer !== null;

        return $this->render(
            'question/answer.html.twig',
            [
                'question' => $question,
                'answer' => $answer,
                'show_answer' => $showAnswer,
                'head_title' => sprintf('Réponse à la question : %s', $question->getQuestion()),
            ]
        );
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/question/', name: 'question_random', methods: ['GET'])]
    public function random(
        QuestionManager $questionManager
    ): Response {
        $question = $questionManager->getContent();

        if ($question === null) {
            throw $this->createNotFoundException('No question found.');
        }

        return $this->render(
            'question/answer.html.twig',
            [
                'question' => $question,
                'answer' => null,
                'show_answer' => null,
                'head_title' => sprintf('Question : %s', $question->getQuestion()),
            ]
        );
    }
}
