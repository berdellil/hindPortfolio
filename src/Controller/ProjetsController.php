<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Form\ProjetsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProjetsController extends AbstractController
{

    
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 

      
    }
    
    /**
     * @Route("/admin/projets/ajout", name="app_projets_ajout")
     * 
     */
    public function projetsAjout(Request $request, SluggerInterface $slugger): Response
    {
        $projets = new Projets();
        $pro = $this->createForm(ProjetsType::class, $projets);  
        $pro->handleRequest($request);

        if($pro->isSubmitted() && $pro->isValid()){
            $photoProjets = $pro->get('image')->getData();      

        if($photoProjets){

           $originalFilename = pathinfo($photoProjets->getClientOriginalName(), PATHINFO_FILENAME);

           $safeFilename = $slugger->slug($originalFilename);

           $newFilename = $safeFilename.'-'.uniqid().'.'.$photoProjets->guessExtension();

             try {

                $photoProjets->move(

                    $this->getParameter('image'),

                    $newFilename

                );

             }catch (FileException $e){

             };

            $projets->setImage($newFilename);
            
            $this->manager->persist($projets);
            $this->manager->flush();

        }
    }
        return $this->render('projets/index.html.twig', [
            'proProjets' => $pro->createView()
        ]);
    
}
     /**
     * @Route("/projets/all", name="app_projets_all")
     * 
     */
    public function allProjets(): Response
    {
        $projets = $this->manager->getRepository(Projets::class)->findAll();

        return $this->render('projets/allProjets.html.twig', [
            'projets' => $projets,
        ]);
    }  
    
                        // POUR VOIR  l'AFFICHAGE DE TT Les Projets DANS LE COTE ADMIN//


                                             // pour supprimer //


     /**
     * @Route("/admin/projets/delete/{id}", name="app_admin_projets_delete")
     * 
     */
    public function projetsDelete(Projets  $projets): Response
    {
      
            $this->manager->remove($projets);
            $this->manager->flush();
            return $this->redirectToRoute('app_projets_all');

    }
                                   // pour modifier //
    /**
    * @Route("admin/edit/projets/{id}", name="app_projets_edit")
    */
    public function projetsEdit(Projets $projets, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProjetsType::class, $projets);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $imageProjets = $form->get('image')->getData();

            if($imageProjets){
                $originalFilename = pathinfo($imageProjets->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '-' . $imageProjets->guessExtension();

                try{
                    $imageProjets->move(
                        $this->getParameter('image'),
                        $newFilename
                    );
                }catch(FileException $e){
                    
                }
                $projets->setImage($newFilename);
            }else{
                dd('Aucune image');
            };

            $this->manager->persist($projets);
            $this->manager->flush();
            return $this->redirectToRoute('app_projets_all');
        };

        return $this->render("projets/editprojets.html.twig", [
            'formEditProjets' => $form->createView(),
        ]);
    }

                         

    /**
     * @Route("/admin/projets/all", name="app_projets_all")
     * 
     */
    public function allProjetsAdmin(): Response
    {
        $allProjets = $this->manager->getRepository(Projets::class)->findAll();


        return $this->render('projets/allProjets.html.twig',[
            'projets' => $allProjets ,
        ]);
    }

                               // SOLO PROJET//
    /**
     * @Route("/solo/projet/{id}", name="app_solo_projet")
     */

    public function solo(Projets $id): Response{
        $projets = $this->manager->getRepository(Projets::class)->find($id);

        return $this->render('projets/soloProjet.html.twig', [

            'projets' => $projets,
        ]);
    }
}