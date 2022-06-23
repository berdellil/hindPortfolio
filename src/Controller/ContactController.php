<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact;

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($contact);
            $this->manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
    // ***********************************GESTION DE CONTACT

     /**

     * @Route("/admin/all/contact", name="admin_app_contact_all")

     */

    public function allcontactAdmin(): Response

    {

       

        $allTable = $this->manager->getRepository(Contact::class)->findAll();  



        // dd($contact);



        return $this->render('contact/gestioncontact.html.twig', [

            'contact' => $allTable,  

        ]);  

    }




}