<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Answer;
use App\Entity\User;
use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AnswerController extends AbstractController 
{
    #[Route('question/{id}/add_answer', name: 'app_add_answer')]
    public function add_answer(Request $request, ValidatorInterface $validator, ManagerRegistry $doctrine, Question $id): Response
    {
        $entityManager = $doctrine->getManager();
        $currentUser = $this->getUser();

        $annonce = $entityManager->getRepository(Annonce::class)->find($id);
        $question = $entityManager->getRepository(Question::class)->find($id);

        $answer = new Answer();
        $answer->setIdQuestion($id);
        $answer->setIdUser($currentUser);
        

        $form = $this->createFormBuilder($answer)
        ->add('answer', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Submit'])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();

            $entityManager->persist($answer);
            $entityManager->flush();

            $question->setIdAnswer($answer);
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce_show', [
              'id' => $question->getIdAnnonce()->getId(),
          ]);
        }

        

        $errors = $validator->validate($answer);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        return $this->renderForm('site/add_answer.html.twig', [
          'form' => $form,
        ]);
    }
}

