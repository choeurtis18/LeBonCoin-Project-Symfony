<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Tag;
use App\Entity\Question;
use App\Entity\Answer;
use App\Entity\User;
use App\Form\AnnonceFormType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

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

        $questions = $doctrine->getRepository(Question::class)->findById($id);
        $currentUser = $this->getUser();
        if($currentUser != null) {
            $userId = $currentUser->getId();
        }
        else {
            $userId = "";
        }

        $answers = $doctrine->getRepository(Answer::class)->findAll();
        if (!$answers) {
            throw $this->createNotFoundException(
                'No questions found for id '.$id
            );
        }

        return $this->render('site/see_annonce.html.twig', ['annonce' => $annonce, 'questions' => $questions, 'answers' => $answers, 'userId' => $userId]);

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

    #[Route('/annonce/update/{id}', name: 'app_annonce_update')]
    public function update(ManagerRegistry $doctrine, int $id, Request $request, EntityManagerInterface $em)
    {
        $annonce = $doctrine->getRepository(Annonce::class)->find($id);
        if (!$annonce) {
            throw $this->createNotFoundException(
                'No annonce found for id '.$id
            );
        }

        //$form = $this->createForm(ArticleFormType::class);
        $form = $this->createForm(AnnonceFormType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success', 'Article Updated! Inaccuracies squashed!');
            return $this->redirectToRoute('app_annonce_show', [
                'id' => $annonce->getId(),
            ]);
        }
        return $this->render('site/edit_annonce.html.twig', [
            'annonceForm' => $form->createView()
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
