<?php

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Controller used to manage current user.
 *
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{


    #[Route('/', name: 'app_profil')]
    public function profil() { 
        return $this->render('site/profil.html.twig');
    }

    
    #[Route('/edit', name: 'app_edit')]
    public function edit(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('user_edit');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profil/change-password', name: 'app_edit_pass')]
    public function changePassword(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $em)
    {

        if ($request->isMethod('POST')){

            $user=$this->getUser();

            if ($request->request->get('password') == $request->request->get('password2')){
                $user->setPassword($encoder->hashPassword($user,$request->request->get('password')));
                $em->flush();
                $this->addFlash('message','Mot de passe bien mis à jour');

                return $this->redirectToRoute('app_logout');
            }
            else{
                $this->addFlash('error','Les deux mots de passe ne sont pas similaires');
            }
        }
    return $this->render('site/edit_pass.html.twig');
    }
}
