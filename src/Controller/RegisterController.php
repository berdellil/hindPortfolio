<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $passwordhasher){

        $this->manager = $manager; 
        $this->passwordhasher = $passwordhasher;

      
    }




    //  *********************Affichage Inscription*******************//
    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request): Response

    {
         $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form -> handLeRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 
            
            $empty = $form->get('password')->getData();
             
          if($empty == null){
              $user->setPassword($user->getPassword());

          }else{
            $encode = $this->passwordhasher->hashPassword($user,$empty); 
            $user->setPassword($encode);

          }

          $this->manager->persist($user);
          $this->manager->flush();


          return $this->redirectToRoute('app_login');
        }



       
        


        return $this->render('register/index.html.twig', [
            'MyUser' => $form->createView(),
        ]);
    }
}
