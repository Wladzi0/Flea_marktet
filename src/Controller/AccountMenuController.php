<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\FavouriteAdvertisement;
use App\Form\AccountDataType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @IsGranted ("ROLE_USER")
 * @Route("/userMenu")
 */
class AccountMenuController extends AbstractController
{
    private  $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * @Route("/", name="app_account")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('userMenu/personalData.html.twig');

    }
    /**
     * @Route("/personalDataEdit", name="personal_data_edit", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function personalDataEdit(Request $request): Response
    {
        $user= $this->security->getUser();
        $userFormInfo=$this->createForm(AccountDataType::class,$user);

        $userFormInfo->handleRequest($request);
        if($userFormInfo->isSubmitted() && $userFormInfo->isValid()){
        $editAvatar= $userFormInfo['avatar']->getData();
        $editFirstName=$userFormInfo['firstName']->getData();
        $editLastName=$userFormInfo['lastName']->getData();
        $editEmail= $userFormInfo['email']->getData();
        if($editAvatar){
            $fileName= md5(uniqid()).'.'.$editAvatar->guessExtension();
            $editAvatar->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $user->setAvatar($fileName);
        }
        if($editFirstName){
            $user->setFirstName($editFirstName);
        }
        if ($editLastName) {
                $user->setLastName($editLastName);
            }
        if($editEmail){
            $user->setLastName($editEmail);
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $this->addFlash('success','Your data has been successfully updated!');
        return $this->RedirectToRoute('app_account');
        }
        return $this->render('userMenu/personalDataEdit.html.twig', [
            'userFormInfo'=>$userFormInfo->createView()
        ]);
    }

    /**
     * @Route ("/myAdvertisements", name="my_advertisements", methods={"GET"})
     * @param Request $request
     * @param UserInterface $user
     * @return Response
     */
    public function showMyAdbert(Request $request, UserInterface $user): Response
    {
        $em=$this->getDoctrine()->getManager();
        $userAdvertisements= $em->getRepository(Advertisement::class)->findAllUserAdv($user);
        return $this-> render('userMenu/myAdvertisements.html.twig',[
            'userAdvertisements'=>$userAdvertisements,
        ]);
    }

    /**
     * @Route ("/myFavouriteAdvertisements", name="favourite_advertisements")
     * @return Response
     */
    public function myFavourite(UserInterface $user): Response
    {
        $userId = $user->getId();
        $entityManager=$this->getDoctrine()->getManager();
        $myFavouriteAdvertisements=$entityManager->getRepository(FavouriteAdvertisement::class)->findAllFavouriteAdvertisementByUser($userId);

        return $this->render('userMenu/myFavourite.html.twig',[
            'user'=>$userId,
            'myFavouriteAdvertisements'=>$myFavouriteAdvertisements
        ]);
    }
}
