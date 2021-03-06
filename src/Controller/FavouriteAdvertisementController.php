<?php

namespace App\Controller;

use App\Entity\FavouriteAdvertisement;
use App\Repository\FavouriteAdvertisementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @IsGranted ("ROLE_USER")
 */
class FavouriteAdvertisementController extends AbstractController
{
    /**
     * @Route("/favourite/advertisement", name="favourite_advertisement_list")
     * @param FavouriteAdvertisementRepository $favouriteAdvertisementRepository
     * @param UserInterface $user
     * @return Response
     */
    public function index(FavouriteAdvertisementRepository $favouriteAdvertisementRepository,UserInterface $user): Response
    {
        $userId= $user->getId();
        $myFavouriteAdvertisements=$favouriteAdvertisementRepository->findAllFavouriteAdvertisementByUser($user);
        return $this->render('favourite_advertisement/index.html.twig', [
            'favouriteAdvertisement' => $myFavouriteAdvertisements,
        ]);
    }
}
