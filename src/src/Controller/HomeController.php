<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnonceRepository $annonceRepo)
    {
        $annonces= $annonceRepo -> findAll();
        $votes = [];

        foreach ($annonces as $annonce) {
            $votes[] = $annonce->getIdUser()->getVoteScore();
        }

        return $this->render('site/index.html.twig', [
                  'annonces' => $annonces,
                  'votes' => $votes,
                  'controller_name' => 'HomeController'
        ]);
      }


}
