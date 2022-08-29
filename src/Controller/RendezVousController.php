<?php

namespace App\Controller;

use App\Form\UserformType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousController extends AbstractController
{

    #[Route('/rendez/vous', name: 'rendez_vous')]
    public function rdv(Request $request, UserRepository $userRepository)
    {

        $rdvForm = $this->createForm(UserformType::class);
        $rdvForm->handleRequest($request);


        return $this->render('rendez_vous/rdv.html.twig', [
            'rdv_Form' => $rdvForm->createView(),
        ]);


    }
}
