<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        return $this->render("site/index.html.twig");
      }


    /**
       * Page d'accès à un article
       * 
       * @Route('/article/{iD}', name='show-article')
       */
      public function show($articleId)
      {
          // Nous retrouvons la valeur de la variable $articleId à partir de l'URI
          // Par exemple /article/1234 => $articleId = '1234'

          return new Response(" Voici le contenu de l'article avec l'ID $articleId ");
      }

}
