<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousController extends AbstractController
{

    #[Route('/rendez/vous', name: 'rendez_vous')]
    public function rdv(Request $request, EntityManagerInterface $em) : Response
    {

        $rdv = new Reservation();

        $rdvForm = $this->createForm(ReservationType::class, $rdv);
        $rdvForm->handleRequest($request);

        if($rdvForm->isSubmitted() && $rdvForm->isValid() ){
            dump($rdvForm->getData());

            $em->persist($rdv);
            $em->flush();

            $this->addFlash('success', 'Votre rendez-vous est validé !');

            return $this->render("rendez_vous/user-rdv.html.twig", [
                'rdv'=>$rdv

            ]);
        }


        return $this->render('rendez_vous/rdv.html.twig', [
            'rdv_form' => $rdvForm->createView(),
        ]);

    
    }



}
