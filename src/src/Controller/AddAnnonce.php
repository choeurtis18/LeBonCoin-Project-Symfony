<?php 

namespace App\Controller; 

use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

class AddAnnonce extends AbstractController { 
    /**
    * @Route("/add_annonce", name="app_add_annonce")
    */ 
    #[Route('/add_annonce', name: 'app_add_annonce')]
    public function add_annonce() { 
        return $this->render('site/add_annonce.html.twig');
    }
}