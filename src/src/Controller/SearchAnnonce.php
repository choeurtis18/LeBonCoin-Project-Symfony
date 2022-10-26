<?php 

namespace App\Controller;

use App\Entity\SearchData;
use App\Form\SearchForm;
use App\Repository\AnnonceRepository;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

class SearchAnnonce  extends AbstractController { 
    /**
    * @Route("/search_annonce ", name="app_search_annonce")
    */ 
    #[Route('/search_annonce', name: 'app_search_annonce')]
    public function search_annonce(AnnonceRepository $repository, Request $request) { 
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        
        $annonces = $repository->findSearch($data);

        return $this->render('site/search_annonce.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView()
        ]);
        /*
        $data->page = $request->get('page', 1);
        $form->handleRequest($request);

        return $this->render('site/search_annonce.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
        */
    }
}