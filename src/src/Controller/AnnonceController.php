<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/ajoutAnnonce', name: 'app_annonce')]
    public function index(): Response
    {
        return $this->render('site/add_annonce.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }
}
