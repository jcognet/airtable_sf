<?php
declare(strict_types=1);

namespace App\Service\Import\Airtable\ToDo\Item;

use App\Service\Import\Airtable\AbstractImporter;

class Importer extends AbstractImporter
{
    public function import(): array
    {
        $data = $this->client->findAll(
            [
                'filterByFormula' => 'OR({Etat}="Ready to go",{Etat}="In progress")',
            ]
        );
        $this->save($data);

        return $data;
    }
}
