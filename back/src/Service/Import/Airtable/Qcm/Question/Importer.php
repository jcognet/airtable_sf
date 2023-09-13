<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\Service\Import\Airtable\AbstractImporter;
use App\ValueObject\Qcm\Question;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Importer extends AbstractImporter
{
    private ?UrlGeneratorInterface $router = null;

    #[Required]
    public function setRouter(?UrlGeneratorInterface $router): void
    {
        $this->router = $router;
    }

    protected function preSave(array $data): array
    {
        /**
         * @var Question $question
         */
        foreach ($data as $question) {
            // We generate the url here so that the app is quicker (one calculation when importing)
            $question->setUrlPageQuestion(
                $this->router->generate(
                    'question_answer',
                    ['id' => $question->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            );
        }

        return $data;
    }
}
