<?php 

namespace App\Controller; 

use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use App\Entity\Annonce;
use App\Entity\Photo;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class AddAnnonce extends AbstractController { 
    /**
    * @Route("/add_annonce", name="app_add_annonce")
    */ 
    #[Route('/add_annonce', name: 'app_add_annonce')]
    public function add_annonce(Request $request, EntityManagerInterface $entityManagerInterface, ManagerRegistry $doctrine) { 
        $annonce = new Annonce();
        $photo = new Photo();
        $current_user = $this->getUser();

        $tags = $doctrine->getRepository(Tag::class)->findAll();

        $array_tags_names = [];
        foreach($tags as $tag){
            array_push($array_tags_names,  $tag->getTag());
        }

        $form = $this->createFormBuilder($annonce)
        ->add("title")
        ->add("description")
        ->add("price")
        ->add("photo", FileType::class, [
            'label' => false,
            'multiple' => true,
            'mapped' => false,
            'required' => false
        ])
        ->add("tag", EntityType::class, [
           'class'=> \App\Entity\Tag::class
        ])
        ->add("submit", SubmitType::class)
        ->getForm();

        
        $annonce->setDate(new \DateTime());
        $annonce->setIdUser($current_user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $images = $form->get("photo")->getData();
            
            foreach($images as $image){
                $fichier = md5(uniqid().'.'. $image->guessExtension());
                $image->move(
                    $this->getParameter("images_directory"), $fichier
                );
                $img = new Photo();
                $img->setUrl($fichier);
                $img->setIdAnnonce($annonce);
                $entityManagerInterface->persist($img);
            }
            $entityManagerInterface->persist($annonce);
            $entityManagerInterface->flush();
        }

        return $this->render('site/add_annonce.html.twig', [
            "form" => $form->createView()
        ]);
    }
}