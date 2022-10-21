<?php 

namespace App\Controller; 

use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

class Profil  extends AbstractController { 
    /**
    * @Route("/profil ", name="app_profil")
    */ 
    #[Route('/profil', name: 'app_profil')]
    public function profil() { 
        return $this->render('site/profil.html.twig');
    }
}