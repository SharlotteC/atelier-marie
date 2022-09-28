<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
Use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route('/user', name: 'user')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function currentUserProfile(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        /**
         * @var User
         */
        
        $user = $this->getUser();
        $userForm = $this -> createForm(UserType::class, $user);
        $userForm->remove('firstname');
        $userForm->remove('lastname');
        $userForm->remove('email');
        $userForm->remove('password');
        $userForm->add('newPassword', PasswordType::class, [
            'attr' => [
                'placeholder' => 'Changer de mot de passe*'
                ]
            ]);
            $userForm->handleRequest($request);
            
            if($userForm->isSubmitted() && $userForm->isValid()){

                $devis = $user->getDeviss();
                dump($devis);              
                $newPassword = $user->getNewPassword();
                
                if($newPassword){
                    $hash = $passwordHasher->hashPassword($user, $newPassword);
                    $user->setPassword($hash);
                }
                $em->flush();
                $this->addFlash('success', 'Modification enregistrée !');
            }
            

        return $this->render('user/user.html.twig', [
            'form' => $userForm->createView()
        ]);
    }
}

