<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Annonce;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class QuestionController extends AbstractController 
{
    /**
    * @Route("annonce/{id}/add_question", name="app_add_question")
    */ 
    #[Route('annonce/{id}/add_question', name: 'app_add_question')]
    public function add_question(Request $request, ValidatorInterface $validator, ManagerRegistry $doctrine, Annonce $id, User $idUser): Response
    {
        $entityManager = $doctrine->getManager();
        $annonce = $entityManager->getRepository(Annonce::class)->find($id);
        $user = $entityManager->getRepository(User::class)->find($idUser);

        $question = new Question();
        $question->setQuestion('Who ?');
        $question->setIdAnnonce($id);
        $question->setIdUser($idUser);

        $form = $this->createFormBuilder($question)
        ->add('question', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Submit'])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();

            return $this->redirectToRoute('app_annonce_show_all');
        }

        $entityManager->persist($question);
        $entityManager->flush();

        $errors = $validator->validate($question);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        return $this->renderForm('site/add_question.html.twig', [
            'form' => $form,
        ]);
    }
}

