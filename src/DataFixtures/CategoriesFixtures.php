<?php

namespace App\DataFixtures;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoryApp= new Category();
        $categoryApp->setName("Appliances");
        $categoryApp->setIcon("fas fa-home");
        // $categoryApp->setSection($sectionCat);
        $categoryFas= new Category();
        $categoryFas->setName("Fashion");
        // $categoryFas->setSection($sectionCat);
        $categoryFas->setIcon("fas fa-tshirt");
        $categoryEle= new Category();
        $categoryEle->setName("Electronics");
        $categoryEle->setIcon("fas fa-mobile");
        // $categoryEle->setSection($sectionCat);
        $categoryToo= new Category();
        $categoryToo->setName("Tools");
        // $categoryToo->setSection($sectionCat);
        $categoryToo->setIcon("fas fa-tools");
        $categorySpo= new Category();
        $categorySpo->setName("Sport and hobby");
        // $categorySpo->setSection($sectionCat);
        $categorySpo->setIcon("fas fa-football-ball");
        $categoryCar= new Category();
        $categoryCar->setName("Cars");
        // $categoryCar->setSection($sectionCat);
        $categoryCar->setIcon("fas fa-car");

        $categoryTax= new Category();
        $categoryTax->setName("BlaBlaCar");
        // $categoryTax->setSection($sectionServ);
        $categoryTax->setIcon("fas fa-taxi");
        $categoryCom= new Category();
        $categoryCom->setName("House equipment repairing");
        // $categoryCom->setSection($sectionServ);
        $categoryCom->setIcon("fas fa-hammer");
        $categoryMan= new Category();
        $categoryMan->setName("Hair and nails");
        // $categoryMan->setSection($sectionServ);
        $categoryMan->setIcon("fas fa-cut");
        $categoryAno= new Category();
        $categoryAno->setName("Another help");
        // $categoryAno->setSection($sectionServ);
        $categoryAno->setIcon("far fa-question-circle");

        $categoryMes= new Category();
        $categoryMes->setName("Messager");
        // $categoryMes->setSection($sectionComm);
        $categoryMes->setIcon("fas fa-comments-dollar");
        $categoryAdm= new Category();
        $categoryAdm->setName("Administration numbers");
        // $categoryAdm->setSection($sectionComm);
        $categoryAdm->setIcon("fas fa-user-shield");


        $manager->persist($categoryMes);
        $manager->persist($categoryAdm);

        $manager->persist($categoryTax);
        $manager->persist($categoryCom);
        $manager->persist($categoryMan);
        $manager->persist($categoryAno);

        $manager->persist($categoryApp);
        $manager->persist($categoryFas);
        $manager->persist($categoryEle);
        $manager->persist($categoryToo);
        $manager->persist($categorySpo);
        $manager->persist($categoryCar);

        $manager->flush();
    }
}
