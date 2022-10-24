<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Tag;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;

class AnnonceController extends AbstractController
{
    #[Route('/create_annonce', name: 'app_create_annonce')]
    public function create_annonce(ValidatorInterface $validator): Response
    {
        $annonce = new Annonce();
        $tag = new Tag('azy');

        $annonce->hydrate(array(
            'title' => 'azerty', 
            'description' => 'Je suis un Zéro',
            'price' => 12, 
            'date' => new Date(), 
            'idUser' => 1,
            'tag' => $tag
        ));

        $errors = $validator->validate($annonce);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        return $this->render('site/add_annonce.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }

    #[Route('/annonce/{id}', name: 'app_annonce_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $annonce = $doctrine->getRepository(Annonce::class)->find($id);
        if (!$annonce) {
            throw $this->createNotFoundException(
                'No annonce found for id '.$id
            );
        }

        return $this->render('site/see_annonce.html.twig', ['annonce' => $annonce]);

        // or render a template
        // in the template, print things with {{ annonce.name }}
        // return $this->render('annonce/show.html.twig', ['annonce' => $annonce]);
    }
    //entity manager interface
    #[Route('/annonce', name: 'app_annonce_show_all')]
    public function show_all(ManagerRegistry $doctrine): Response
    {
        $annonces = $doctrine->getRepository(Annonce::class)->findAll();
        if (!$annonces) {
            throw $this->createNotFoundException(
                'No annonces found'
            );
        }

        return $this->render('site/index.html.twig', ['annonces' => $annonces]);

        // or render a template
        // in the template, print things with {{ annonce.name }}
        // return $this->render('annonce/show.html.twig', ['annonce' => $annonce]);
    }
    #[Route('/annonce/edit/{id}', name: 'app_annonce_edit')]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $annonce = $entityManager->getRepository(Annonce::class)->find($id);

        if (!$annonce) {
            throw $this->createNotFoundException(
                'No annonce found for id '.$id
            );
        }

        $annonce->setName('New annonce name!');
        $entityManager->flush();

        return $this->redirectToRoute('annonce_show', [
            'id' => $annonce->getId()
        ]);
    }
    
    #[Route('/annonce/delete/{id}', name: 'app_annonce_delete')]
    public function delete(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $annonce = $entityManager->getRepository(Annonce::class)->find($id);

        if (!$annonce) {
            throw $this->createNotFoundException(
                'No annonce found for id '.$id
            );
        }

        $entityManager->remove($annonce);
        $entityManager->flush();

        $annonces = $doctrine->getRepository(Annonce::class)->findAll();
        if (!$annonces) {
            throw $this->createNotFoundException(
                'No annonces found'
            );
        }

        return $this->render('site/index.html.twig', ['annonces' => $annonces]);
    }
}
