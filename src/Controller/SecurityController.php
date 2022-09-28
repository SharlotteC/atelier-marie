<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ResetPasswordRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SecurityController extends AbstractController
{
    #[Route('/signup', name: 'signup')]
    public function signup(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()){
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Bienvenue sur l'atelier de Marie");

            $welcomeEmail = new TemplatedEmail();
            $welcomeEmail->to($user->getEmail())
                        ->subject("Bienvenue à l'atelier de Marie")
                        ->htmlTemplate('@email_templates/welcome.html.twig')
                        ->context(
                            ['username'=> $user->getFirstname()]
                        );

            $mailer->send($welcomeEmail);

            return $this->redirectToRoute('login');
        }

        return $this->render('security/signup.html.twig', ['form' => $userForm->createView()]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('home_page');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {}

    #[Route('/reset-password-request', name: 'reset-password-request')]
    public function resetPasswordRequest(Request $request, UserRepository $userRepo, ResetPasswordRepository $resetPasswordRepo, EntityManagerInterface $em, MailerInterface $mailer)
    {

        $emailResetRequestForm = $this ->createFormBuilder()
                                    ->add('email', EmailType::class,[
                                        'label'=> 'Votre Email:',
                                        'constraints'=>[
                                            new NotBlank([
                                                'message'=> 'Veuillez entrer votre email'
                                            ]),
                                            new Email([
                                                'message' => 'Veuillez entrer un email valide'
                                            ])
                                        ]

                                    ])
                                    ->getForm();
        $emailResetRequestForm->handleRequest($request);
        if($emailResetRequestForm->isSubmitted() && $emailResetRequestForm->isValid()){
            $emailUser = $emailResetRequestForm->get('email')->getData();
            $user = $userRepo->findOneBy(['email' => $emailUser]);

            if($user) {

                //verification d'ancienne demande
                $oldResetPassword = $resetPasswordRepo->findOneBy(['user' => $user]);
                if($oldResetPassword){
                    $resetPasswordRepo->remove($oldResetPassword, true);
                }

                $token = substr(str_replace(['+','/','='], '', base64_encode(random_bytes(40))), 0, 20);
                $resetPassword = new ResetPassword();
                $resetPassword->setUser($user)
                            ->setExpiredAt(new \DateTimeImmutable('+2 hours'))
                            ->setToken($token);             
                $em->persist($resetPassword);
                $em->flush();
                //envoi du mail de réinitialisation
                $emailResetRequest = new TemplatedEmail();
                $emailResetRequest->to($emailUser)
                                    ->subject('demande de réinitialisation de mot de passe')
                                    ->htmlTemplate('@email_templates/reset_password_request.html.twig')
                                    ->context([
                                        'username'=> $user->getFirstname(),
                                        'token' =>  $token
                                    ]);
                
                $mailer->send($emailResetRequest);
            }
            $this->addFlash('success', 'Un Email vous a été envoyé !');
            return $this->redirectToRoute('home_page');
        }                      
        return $this->render('security/reset_password_request.html.twig',[
            'form'=> $emailResetRequestForm->createView()
        ]);
    }

    #[Route('/reset-password/{token}', name: 'reset-password')]
    public function resetPassword(string $token, ResetPasswordRepository $resetPasswordRepo, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, Request $request){
        $resetPassword = $resetPasswordRepo->findOneBy(['token' => $token]);

        if(!$resetPassword || $resetPassword->getExpiredAt() < new \DateTime('now')){
            if($resetPassword){
                $resetPasswordRepo->remove($resetPassword, true);
            }
            $this-> addFlash('error', "Votre demande a expiré");
            return $this->redirectToRoute('login');
        }
        $passwordResetForm = $this ->createFormBuilder()
                                    ->add('password', PasswordType::class, [
                                        'label' => 'Nouveau mot de passe:',
                                        'constraints' => [
                                            new Length([
                                                'min' => 8,
                                                'minMessage'=>'Le mot de passe doit faire aun moins 8 caractères'
                                            ]),
                                            new NotBlank([
                                                'message'=> 'Veuillez entrez un nouveau mot de passe'
                                            ])
                                        ]
                                    ])
                                    ->getForm();
        $passwordResetForm->handleRequest($request);
        if($passwordResetForm->isSubmitted() && $passwordResetForm->isValid()){

            $newPassword = $passwordResetForm->get('password')->getData();
            $user = $resetPassword->getUser();

            $hash = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hash);

            $em->remove($resetPassword);
            $em->flush();

            $this->addFlash('success','Votre mot de passe a été modifié');
            return $this->redirectToRoute('login');
        }
        return $this->render('security/reset_password_form.html.twig',[
            'form' => $passwordResetForm->createView()
        ]);
    }
}
