<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Annonce;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
       
        // admin
        $admin=new user();
        $admin -> setEmail("crystal@gmail.com");
        $password= $this -> hasher -> hashPassword($admin,'Choeurtismuscle');
        $admin -> setPassword($password);
        $admin -> setRoles(["ROLE_ADMIN"]);
        $admin -> setIsSeller(true);
        $admin -> setFirstName("Crystal");
        $admin -> setLastName("Latsyrc");
        $manager -> persist($admin);

        //Seller
        $Seller1= new User();
        $Seller1->setEmail("farah@gmail.com");
        $password=$this->hasher->hashPassword($Seller1,'Redbull');
        $Seller1->setPassword($password);
        $Seller1->setIsSeller(true);
        $Seller1->setRoles(["ROLE_Seller"]);
        $Seller1->setFirstName("Farah");
        $Seller1->setLastName("Doghri");
        $manager->persist($Seller1);

        $Seller2= new User();
        $Seller2->setEmail("melvin@gmail.com");
        $password=$this->hasher->hashPassword($Seller2,'heticien');
        $Seller2->setPassword($password);
        $Seller2->setIsSeller(true);
        $Seller2->setRoles(["ROLE_Seller"]);
        $Seller2->setFirstName("Melvin");
        $Seller2->setLastName("Tom-A-Kien");
        $manager->persist($Seller2);



        //Tag
        $Tag1= new Tag();
        $Tag1->setTag("Appareils-electroniques");
        $manager->persist($Tag1);

        $Tag2= new Tag();
        $Tag2->setTag("Véhicules");
        $manager->persist($Tag2);

        $Tag3= new Tag();
        $Tag3->setTag("Meubles");
        $manager->persist($Tag3);

        $Tag4= new Tag();
        $Tag4->setTag("Vetements, chaussures et accessoires");
        $manager->persist($Tag4);

        
        //Annonces
        $Annonce1= new Annonce();
        $datepubl1 = new DateTime("2022-10-12");
        $Annonce1->setTitle("Macbook Pro");
        $Annonce1->setDescription("État correct");
        $Annonce1->setPrice(300);
        $Annonce1->setDate($datepubl1);
        $Annonce1->setTag($Tag1);
        $Annonce1->setIdUser($Seller1);
        $manager->persist($Annonce1);

        $Annonce2= new Annonce();
        $datepubl2 = new DateTime("2022-09-25");
        $Annonce2->setTitle("Golf V");
        $Annonce2->setDescription("D’occasion - comme neuf");
        $Annonce2->setPrice(3500);
        $Annonce2->setDate($datepubl2);
        $Annonce2->setTag($Tag2);
        $Annonce2->setIdUser($Seller1);
        $manager->persist($Annonce2); 

        $Annonce3= new Annonce();
        $datepubl3 = new DateTime("2022-08-25");
        $Annonce3->setTitle("Lit 1 place");
        $Annonce3->setDescription("D’occasion - comme neuf");
        $Annonce3->setPrice(100);
        $Annonce3->setDate($datepubl3);
        $Annonce3->setTag($Tag3);
        $Annonce3->setIdUser($Seller2);
        $manager->persist($Annonce3); 

        $Annonce4= new Annonce();
        $datepubl4 = new DateTime("2022-10-10");
        $Annonce4->setTitle("The North Face doudoune ");
        $Annonce4->setDescription("Comme neuf");
        $Annonce4->setPrice(120);
        $Annonce4->setDate($datepubl4);
        $Annonce4->setTag($Tag4);
        $Annonce4->setIdUser($Seller1);
        $manager->persist($Annonce4); 


        $manager->flush();
    }
}
