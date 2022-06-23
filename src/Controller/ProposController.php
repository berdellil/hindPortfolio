<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProposController extends AbstractController
{
    /**
     * @Route("/propos", name="app_propos")
     */
    public function index(): Response
    {
        return $this->render('propos/index.html.twig', [
            'controller_name' => 'ProposController',
        ]);
    }
}
