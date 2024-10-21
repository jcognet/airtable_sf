<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/login_check', name: 'login_check')]
    public function check(): never
    {
        throw new \LogicException('This code should never be reached');
    }
}
