<?php

namespace App\Tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\User\InMemoryUser;

trait SetUserTrait
{
    private function loginUser(KernelBrowser $client):void{
        $user = new InMemoryUser(
            'jcognet',
            '$2y$13$geEXiKQSBsX1ESN2Ryvx/eW21uC6yQzpEAqyEdhxhRFx9qckqfHgG',
            ['ROLE_USER']
        );
        $client->loginUser($user);
    }
}
