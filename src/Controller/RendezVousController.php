<?php

namespace App\Controller;

use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousController extends AbstractController
{

    #[Route('/rendez/vous', name: 'rendez_vous')]
    public function user(Request $request)
    {

        $rdvForm = $this->createForm(ReservationType::class);


        return $this->render('rendez_vous/rdv.html.twig', [
            'rdv_form' => $rdvForm->createView(),
        ]);

    
    }


}
