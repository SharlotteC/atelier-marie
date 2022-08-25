<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BenefitPageController extends AbstractController
{
    #[Route('/benefit', name: 'benefit_page')]
    public function index(): Response
    {
        return $this->render('benefit_page/benefit.html.twig', [
            'controller_name' => 'BenefitPageController',
        ]);
    }
}
