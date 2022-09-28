<?php

namespace App\Controller\Admin;

use App\Entity\Devis;
use App\Form\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DevisController extends AbstractController
{
    #[Route('/admin/devis', name: 'admin_devis')]
    public function devis(Request $request, EntityManagerInterface $em): Response
    {
        // $user = $this->getUser();
        
        // $devis = new Devis();
        // $devisForm = $this->createForm(DevisType::class, $devis);
        // $devisForm->handleRequest($request);

        // if ($devisForm->isSubmitted() && $devisForm->isValid()) {

        //     if ($user) {
        //         $devis->setUser($user);
        //     }

        //     $em->persist($devis);
        //     $em->flush();
        //     $this->addFlash('success', ' Nous avons bien reçu votre devis !');

        //     $devisEmail = new TemplatedEmail();
        //     $devisEmail->to($devis->getEmail())
        //                 ->subject('Votre demande de devis')
        //                 ->htmlTemplate('@email_templates/devis.html.twig')
        //                 ->context(
        //                     [
        //                         'username'=>$devis->getFirstname(),
        //                         'devisTitle'=>$devis->getTitle(),
        //                         'devisContent'=>$devis->getContent()
                                        
        //                     ]
        //                 );
        //     $mailer->send($devisEmail);


        //     return $this->render("devis/user_devis.html.twig", [
        //         'devis' => $devis
        //     ]);
        // }
        return $this->render('admin/index.html.twig', [
            'controller_name' => "DevisController",
        ]);
    }
}
