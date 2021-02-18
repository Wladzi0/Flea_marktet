<?php

namespace App\DataFixtures;

use App\Entity\Advertisement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdvertisementsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {



        $manager->flush();
    }
}
