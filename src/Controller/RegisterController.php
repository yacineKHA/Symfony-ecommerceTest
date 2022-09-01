<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
//use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    //instance de doctrine car on s'en sert souvent
    //private EntityManagerInterface $entityManager;

//    private EntityManagerInterface $entityManager;

//    public function __construct(EntityManagerInterface $entityManager){
//        $this->entityManager = $entityManager;
//    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $encoder): Response
    {

        $entityManager = $doctrine->getManager();

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $password = $encoder->hashPassword($user, $user->getPassword());

            $doctrine = 

            $user->setPassword($password);
            $entityManager->persist($user);
            $entityManager->flush();


//           $this->entityManager->persist($user);
            //lui demande de l'envoyer en BDD, perme

//            $this->entityManager->flush();
        }

        return $this->render('register/index.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}
