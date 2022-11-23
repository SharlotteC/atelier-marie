<?php

namespace App\Controller\Admin;

use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function showDevis(DevisRepository $devisRepo ): Response
    {
        return $this->render('admin/admin.html.twig', [
            'deviss' => $devisRepo->findAll(),
        ]);
    }
    #[Route('/remove/{id}', name: 'devis_remove')]
    public function removeDevis( int $id, EntityManagerInterface $em, DevisRepository $devisRepo ): Response
    {
        $devis = $devisRepo->find($id);
        
        $em->remove($devis);
        $em->flush();

        return $this->render('admin/admin.html.twig', [
            'deviss' => $devisRepo->findAll(),
        ]);
    }
}
    
