<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder=$passwordEncoder;

    }
    public function load(ObjectManager $manager)
    {
        $admin= new User();
        $admin->setFirstName('Vladyslav');
        $admin->setLastName('Svizinskyi');
        $admin->setEmail('vlad.svizinskiy@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin1'
        ));
        $manager->persist($admin);
        $manager->flush();

    }
}