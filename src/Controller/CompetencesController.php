<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetencesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetencesController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 

      
    }
    //   ***********************************Ajouter Competences****************************  //

    /**
     * @Route("/competences/ajout", name="app_competences_ajout")
     * 
     */
    public function competencesAjout(Request $request): Response
    {
        $competences = new Competences();
        $form = $this->createForm(CompetencesType::class, $competences);  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($competences);
            $this->manager->flush();

        }

        return $this->render('competences/index.html.twig', [
            'formCompetences' => $form->createView(),
        ]);
    }

    /**
     * @Route("/competences/tout", name="app_competences_tout")
     * 
     */
    public function touteLEsCompetance(Request $request): Response
    {
        $competences = $this->manager->getRepository(Competences::class)->findAll();

        return $this->render('competences/touteLesCompetance.html.twig', [
            'competences' => $competences,
        ]);
    }
//***********************************  Supprimer Compétences *************************************************//
                                           // pour supprimer //


     /**
     * @Route("/admin/competences/delete/{id}", name="app_admin_competences_delete")
     * 
     */
    public function competencesDelete(Competences  $competences): Response
    {
      
            $this->manager->remove($competences);
            $this->manager->flush();
            return $this->redirectToRoute('app_competences_tout');

            

    }

    // ******************************************* Modifier  & **********************************************************************************//
    /**
     * @Route("/admin/competences/edit/{id}", name="app_admin_competences_edit")
     * 
     */
    public function competencesEdit(Competences  $competences,Request $request): Response
    {
      
        $formEdit= $this->createForm(CompetencesType::class, $competences);  
        $formEdit->handleRequest($request);
        if($formEdit->isSubmitted() && $formEdit->isValid()){
            $this->manager->persist($competences);
            $this->manager->flush();
            return $this->redirectToRoute('app_competences_tout');

        }

        return $this->render('competences/editCompetences.html.twig', [
            'CompetencesEdit' => $formEdit->createView(),
        ]);
    }

    /**
     * @Route("/admin/competences/tout", name="admin_app_competences_tout")
     * 
     */
    public function touteLesCompetencesAdmin(): Response
    {
        $toutCompetences= $this->manager->getRepository(Competences::class)->findAll();


        return $this->render('competences/touteLesCompetences.html.twig',[
            'competences' => $toutCompetences ,
        ]);
    }


                         
}
