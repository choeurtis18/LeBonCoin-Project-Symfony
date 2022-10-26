<?php 

namespace App\Controller; 

use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use App\Entity\Annonce;
use App\Entity\Photo;
use App\Entity\Tag;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
        ->add("title", TextType::class,[
            "label"=> "Titre",
            "attr"=>[
                'placeholder' => 'Exemple : Ordinateur',
                "class"=> "block w-2/3 text-sm bg-gray-50 rounded-lg border border-gray-300 cursor-pointer  focus:outline-none p-3 my-2"
            ]
        ])
        ->add("description", TextType::class,[
            "label"=> "Descriprion",
            "attr"=>[
                'placeholder' => 'Exemple : lorem',
                "class"=> "block w-2/3 text-sm bg-gray-50 rounded-lg border border-gray-300 cursor-pointer  focus:outline-none p-3 my-2"
            ]
        ])
        ->add("price", NumberType::class,[
            "label"=> "Prix",
            "attr"=>[
                'placeholder' => 'Exemple : 78',
                "class"=> "block w-2/3 text-sm bg-gray-50 rounded-lg border border-gray-300 cursor-pointer  focus:outline-none p-3 my-2"
            ]
        ])
        ->add("photo", FileType::class, [

            'multiple' => true,
            'mapped' => false,
            'required' => false,
            "attr"=>[
                "class"=> "block w-2/3 text-sm bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none p-2 my-2"
            ]
        ])
        ->add("tag", EntityType::class, [
           'class'=> \App\Entity\Tag::class,
           "attr"=>[
            "class" => "block w-2/3 text-sm bg-gray-50 rounded-lg border border-gray-300 cursor-pointer  focus:outline-none p-2 my-2"
           ]
        ])
        ->add("submit", SubmitType::class, [
            "label"=> "Valider",
            "attr"=>[
                "class"=> "focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            ]
        ])
        ->getForm();

        
        $annonce->setDate(new \DateTime());
        $annonce->setIdUser($current_user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $images = $form->get("photo")->getData();
            
            foreach($images as $image){
                $fichier = md5(uniqid()). '.' . $image->guessExtension();
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