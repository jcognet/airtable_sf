<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\Qcm\Question;

use App\ValueObject\Qcm\Question;
use Symfony\Component\Filesystem\Filesystem;

class QuestionLister
{
    public function __construct(
        private readonly Config $config
    ) {
    }

    /**
     * @return Question[]|null
     */
    public function list(): ?array
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->config->getFileName())) {
            return null;
        }

        $data = json_decode(file_get_contents($this->config->getFileName()), true, 512, JSON_THROW_ON_ERROR);
        $questions = [];

        foreach ($data['data']['questions'] as $questionJson) {
            unset($questionJson['managerType'], $questionJson['managerTypeValue'], $questionJson['class']);
            $questions[] = new Question(...$questionJson);
        }

        return $questions;
    }
}
