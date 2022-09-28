<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function home(): Response
    {
        

        return $this->render('home/home_page.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('mention', name: 'mention')]
    public function mention(): Response
    {
        
        return $this->render('home/mention.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


}
