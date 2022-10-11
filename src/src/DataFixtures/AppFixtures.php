<?php

namespace App\DataFixtures;


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
        // $product = new Product();
        // $manager->persist($product);
        $admin=new user();
        $admin -> setEmail("crystal@gmail.com");
        $password= $this -> hasher -> hashPassword($admin,'Choeurtismuscle');
        $admin -> setPassword($password);
        $admin -> setRoles(["ROLE_ADMIN"]);
        $admin -> setIsSeller(true);
        $admin -> setFirstName("Crystal");
        $admin -> setLastName("Latsyrc");
        $manager -> persist($admin);
  


        $manager->flush();
    }
}
