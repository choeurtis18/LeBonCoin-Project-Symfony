<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnonceRepository $annonceRepo)
    {
      
        $annonces= $annonceRepo -> findAll();

        return $this->render('site/index.html.twig', [
                  'annonces' => $annonces,
                  'controller_name' => 'HomeController'
        ]);
      }


}
