<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Form\FormationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class FormationsController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 

      
    }

    /**
     * @Route("/formations/ajout", name="app_formations_ajout")
     * 
     */
      public function formationsAjout(Request $request): Response
        {
            $formations = new Formations();
            $form = $this->createForm(FormationsType::class, $formations);  
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $this->manager->persist($formations);
                $this->manager->flush();
    
            }
    
            return $this->render('formations/index.html.twig', [
                'formFormations' => $form->createView(),
            ]);
        }

    /**
     * @Route("/formations/tout", name="app_formations_tout")
     * 
     */
    public function touteLesFormations(): Response
    {
        $formations = $this->manager->getRepository(Formations::class)->findAll();

        return $this->render('formations/touteLesFormations.html.twig', [
            'formations' => $formations,
        ]);
    }  

                        // POUR VOIR  l'AFFICHAGE DE TT LES FORMATIONS DANS LE COTE ADMIN//


                                             // pour supprimer //


     /**
     * @Route("/admin/formations/delete/{id}", name="app_admin_formations_delete")
     * 
     */
    public function formationsDelete(Formations  $formations): Response
    {
      
            $this->manager->remove($formations);
            $this->manager->flush();
            return $this->redirectToRoute('app_formations_tout');

    }

                                                 // pour modifier //

    /**
     * @Route("/admin/formations/edit/{id}", name="app_admin_formations_edit")
     * 
     */
    public function formationsEdit(Formations  $formations,Request $request): Response
    {
      
        $formEdit= $this->createForm(FormationsType::class, $formations);  
        $formEdit->handleRequest($request);
        if($formEdit->isSubmitted() && $formEdit->isValid()){
            $this->manager->persist($formations);
            $this->manager->flush();
            return $this->redirectToRoute('app_formations_tout');

        }

        return $this->render('formations/editformations.html.twig', [
            'FormationsEdit' => $formEdit->createView(),
        ]);
    }
                         

    /**
     * @Route("/admin/formations/tout", name="admin_app_formations_tout")
     * 
     */
    public function touteLesFormationsAdmin(): Response
    {
        $toutFormations = $this->manager->getRepository(Formations::class)->findAll();


        return $this->render('formations/touteLesFormations.html.twig',[
            'formations' => $toutFormations ,
        ]);
    }




}
