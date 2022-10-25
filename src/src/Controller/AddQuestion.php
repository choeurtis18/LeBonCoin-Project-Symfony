<?php 

namespace App\Controller; 

use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

class AddQuestion extends AbstractController { 
    /**
    * @Route("/add_question", name="app_add_question")
    */ 
    #[Route('/add_question', name: 'app_add_question')]
    public function add_question() { 
        return $this->render('site/add_question.html.twig');
    }
}