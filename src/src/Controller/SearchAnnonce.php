<?php 

namespace App\Controller; 

use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

class SearchAnnonce  extends AbstractController { 
    /**
    * @Route("/search_annonce ", name="app_search_annonce")
    */ 
    #[Route('/search_annonce', name: 'app_search_annonce')]
    public function search_annonce() { 
        return $this->render('site/search_annonce.html.twig');
    }
}