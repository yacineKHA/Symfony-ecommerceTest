<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    //instance de doctrine car on s'en sert souvent
    private EntityManagerInterface $entityManager;

    public function __construct( EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/account/modifier-mon-mot-de-passe', name: 'app_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);

        $notification = null;

        if ($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('password')->getData();

            if ($encoder->isPasswordValid($user, $old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_password);

                $user->setPassword($password);
                $this->entityManager->persist($user);//pas forcement besoin de persist(), à en voir plus la dessus
                //plutot pour la création d'entité pas forcement pour la mise a jour
                $this->entityManager->flush();

                $notification = 'Votre mot de passe a été mis à jour';

            } else{
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('account/password.html.twig', [
            'form'=> $form->createView(),
            'user'=> $user,
            'notification'=> $notification
        ]);


    }
}
