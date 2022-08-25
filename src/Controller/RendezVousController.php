<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/rdv.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }
}
