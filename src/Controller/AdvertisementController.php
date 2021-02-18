<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementController extends AbstractController
{
    /**
     * @Route("/advertisement", name="advertisement")
     */
    public function index(): Response
    {
        return $this->render('advertisement/index.html.twig', [
            'controller_name' => 'AdvertisementController',
        ]);
    }
}
