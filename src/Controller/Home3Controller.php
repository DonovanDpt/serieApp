<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Home3Controller extends AbstractController
{
    #[Route('/home3', name: 'app_home3')]
    public function index(): Response
    {
        return $this->render('home3/index.html.twig', [
            'controller_name' => 'Home3Controller',
        ]);
    }
}
