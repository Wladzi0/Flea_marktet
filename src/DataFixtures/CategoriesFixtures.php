<?php

namespace App\DataFixtures;
use App\Entity\Advertisement;
use App\Entity\Category;
use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoryApp= new Category();
        $categoryApp->setName("Appliances");
        $categoryApp->setIcon("fas fa-home");

        $categoryFas= new Category();
        $categoryFas->setName("Fashion");
        $categoryFas->setIcon("fas fa-tshirt");

        $categoryEle= new Category();
        $categoryEle->setName("Electronics");
        $categoryEle->setIcon("fas fa-laptop");

        $categoryToo= new Category();
        $categoryToo->setName("Tools");
        $categoryToo->setIcon("fas fa-tools");

        $categorySpo= new Category();
        $categorySpo->setName("Sport and hobby");
        $categorySpo->setIcon("fas fa-football-ball");

        $categoryCar= new Category();
        $categoryCar->setName("Cars");
        $categoryCar->setIcon("fas fa-car");

        $categoryTax= new Category();
        $categoryTax->setName("BlaBlaTravel");
        $categoryTax->setIcon("fas fa-route");

        $categoryCom= new Category();
        $categoryCom->setName("House equipment repairing");
        $categoryCom->setIcon("fas fa-hammer");

        $categoryBea= new Category();
        $categoryBea->setName("Beauty");
        $categoryBea->setIcon("fas fa-cut");

//subcategory
        $climatic= new Subcategory();
        $climatic->setCategory($categoryApp);
        $climatic->setName("Climatic technology");

        $largeApp= new Subcategory();
        $largeApp->setCategory($categoryApp);
        $largeApp->setName("Large Appliances");

        $care= new Subcategory();
        $care->setCategory($categoryApp);
        $care->setName("Care and cleaning");

        $kitchen= new Subcategory();
        $kitchen->setCategory($categoryApp);
        $kitchen->setName("Kitchen");

        $plumbing= new Subcategory();
        $plumbing->setCategory($categoryApp);
        $plumbing->setName("Plumbing and bathroom");

        $household= new Subcategory();
        $household->setCategory($categoryApp);
        $household->setName("Household chemical");

        $car= new Subcategory();
        $car->setCategory($categoryCar);
        $car->setName("Cars");

        $motorcycles= new Subcategory();
        $motorcycles->setCategory($categoryCar);
        $motorcycles->setName("Motorcycles");

        $tracks= new Subcategory();
        $tracks->setCategory($categoryCar);
        $tracks->setName("Tracks");

        $laptops= new Subcategory();
        $laptops->setCategory($categoryEle);
        $laptops->setName("Laptops");

        $phones= new Subcategory();
        $phones->setCategory($categoryEle);
        $phones->setName("Phones");

        $sound= new Subcategory();
        $sound->setCategory($categoryEle);
        $sound->setName("Sound");

        $blaBlaBus= new Subcategory();
        $blaBlaBus->setCategory($categoryTax);
        $blaBlaBus->setName("BlaBlaBus");

        $blaBlaCars= new Subcategory();
        $blaBlaCars->setCategory($categoryTax);
        $blaBlaCars->setName("BlaBlaCars");

        $forWomen= new Subcategory();
        $forWomen->setCategory($categoryFas);
        $forWomen->setName("For women");

        $forMen= new Subcategory();
        $forMen->setCategory($categoryFas);
        $forMen->setName("For men");

        $forChildren= new Subcategory();
        $forChildren->setCategory($categoryFas);
        $forChildren->setName("For children");

        $hair= new Subcategory();
        $hair->setCategory($categoryBea);
        $hair->setName("Hair");

        $nails= new Subcategory();
        $nails->setCategory($categoryBea);
        $nails->setName("Nails");


        $elecRep= new Subcategory();
        $elecRep->setCategory($categoryCom);
        $elecRep->setName("Electronics repair");

        $plumRep= new Subcategory();
        $plumRep->setCategory($categoryCom);
        $plumRep->setName("Plumbing repair");

        $carpenRep= new Subcategory();
        $carpenRep->setCategory($categoryCom);
        $carpenRep->setName("Carpentry work");

        $homeRenov= new Subcategory();
        $homeRenov->setCategory($categoryCom);
        $homeRenov->setName("Electronics repair");


        $homeRenov= new Subcategory();
        $homeRenov->setCategory($categoryCom);
        $homeRenov->setName("Electronics repair");

        $sportNur= new Subcategory();
        $sportNur->setCategory($categorySpo);
        $sportNur->setName("Sport nutrition");

        $fishing= new Subcategory();
        $fishing->setCategory($categorySpo);
        $fishing->setName("Fishing");

        $tourism= new Subcategory();
        $tourism->setCategory($categorySpo);
        $tourism->setName("Tourism and camping");

        $instrument= new Subcategory();
        $instrument->setCategory($categorySpo);
        $instrument->setName("Musical instruments");

        $instrument= new Subcategory();
        $instrument->setCategory($categorySpo);
        $instrument->setName("Musical instruments");

        $tools= new Subcategory();
        $tools->setCategory($categoryToo);
        $tools->setName("Tools");

        $equipment= new Subcategory();
        $equipment->setCategory($categoryToo);
        $equipment->setName("Equipments");

        $elEquipment= new Subcategory();
        $elEquipment->setCategory($categoryToo);
        $elEquipment->setName("Electronically equipments");

    //advertisements
        $carBot= new Advertisement();
        $carBot->setSubcategory($car);
        $carBot->setName("BWM 520d");
        $carBot->setDescription("Witam!\nSuzuki Jimny\n
Rok 2008.Samochód lekko uszkodzony\nWięcej informacji pod numerem telefonu 694 - wyświetl numer - lub 519 - wyświetl numer -");
        $carBot->setPrice('22222');
        $carBot->setCreatedAt(new \DateTime());

        $carBot2= new Advertisement();
        $carBot2->setSubcategory($car);
        $carBot2->setName("Audi A6 C5");
        $carBot2->setDescription("Witam!\nSuzuki Jimny\n
Rok 2008.Samochód lekko uszkodzony\nWięcej informacji pod numerem telefonu 694 - wyświetl numer - lub 519 - wyświetl numer -");
        $carBot2->setPrice('22222');
        $carBot2->setCreatedAt(new \DateTime());

        $manager->persist($categoryApp);
        $manager->persist($categoryTax);
        $manager->persist($categoryCar);
        $manager->persist($categoryEle);
        $manager->persist($categoryFas);
        $manager->persist($categoryBea);
        $manager->persist($categoryCom);
        $manager->persist($categorySpo);
        $manager->persist($categoryToo);
        //sub
        $manager->persist($care);
        $manager->persist($climatic);
        $manager->persist($kitchen);
        $manager->persist($largeApp);
        $manager->persist($household);
        $manager->persist($plumbing);

        $manager->persist($blaBlaBus);
        $manager->persist($blaBlaCars);

        $manager->persist($car);
        $manager->persist($motorcycles);
        $manager->persist($tracks);

        $manager->persist($laptops);
        $manager->persist($phones);
        $manager->persist($sound);

        $manager->persist($forChildren);
        $manager->persist($forMen);
        $manager->persist($forWomen);

        $manager->persist($hair);
        $manager->persist($nails);

        $manager->persist($carpenRep);
        $manager->persist($elecRep);
        $manager->persist($homeRenov);
        $manager->persist($plumRep);

        $manager->persist($fishing);
        $manager->persist($instrument);
        $manager->persist($sportNur);
        $manager->persist($tourism);

        $manager->persist($tools);
        $manager->persist($equipment);
        $manager->persist($elEquipment);

        $manager->persist($carBot);
        $manager->persist($carBot2);

        $manager->flush();
    }
}
