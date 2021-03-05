<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Comment;
use App\Entity\FavouriteAdvertisement;
use App\Entity\Image;
use App\Form\AdvertisementType;
use App\Form\CommentType;
use App\Repository\FavouriteAdvertisementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted ("ROLE_USER")
 * @Route("/advertisement")
 */
class AdvertisementController extends AbstractController
{
    /**
     *
     * @Route("/advertisement", name="advertisement")
     */
    public function index(): Response
    {
        return $this->render('advertisement/index.html.twig', [
            'controller_name' => 'AdvertisementController',
        ]);
    }

    /**
     * @Route ("/{id}", name="advertisement_details", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param Advertisement $advertisement
     * @return Response
     */
    public function showAdvertisementDetails(Request $request, Advertisement $advertisement): Response
    {
        $advertisement= $this->getDoctrine()->getRepository(Advertisement::class)->find($request->get('id'));
        return $this->render('advertisement/advertisementDetails.html.twig', [
            'advertisement' => $advertisement,

        ]);
    }

    /**
     * @Route("/new", name="new_advertisement", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newAdvertisement(Request $request): Response
    {
        $advertisement = new Advertisement();
        $advertisementForm = $this->createForm(AdvertisementType::class, $advertisement);
        $advertisementForm->handleRequest($request);

        if ($advertisementForm->isSubmitted() && $advertisementForm->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $advertisement->setUser($user);
            $images = $advertisementForm->get('image')->getData();
            foreach ($images as $image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('advertisement_images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $advertisement->addImage($img);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($advertisement);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your advertisement has been added successfully');
            return $this->redirectToRoute('start_page');
        }

        return $this->render('advertisement/new.html.twig', [
            'advertisement' => $advertisement,
            'advertisementForm' => $advertisementForm->createView(),
        ]);

    }

    /**
     * @Route("/{id}/edit", name="edit_advertisement", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function editAdvertisement(Request $request,Advertisement $advertisement): Response
    {
        $advertisementForm = $this->createForm(AdvertisementType::class, $advertisement);
        $advertisementForm->handleRequest($request);

        if ($advertisementForm->isSubmitted() && $advertisementForm->isValid()) {
            $images = $advertisementForm->get('image')->getData();
            foreach ($images as $image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('advertisement_images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $advertisement->addImage($img);
            }
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your advertisement has been edited successfully ');


            return $this->redirectToRoute($request->get('_route'));
        }

        return $this->render('advertisement/edit.html.twig', [
            'advertisement' => $advertisement,
            'advertisementForm' => $advertisementForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete_advertisement", methods={"DELETE"}, requirements={"id"="\d+"} )
     * @param Request $request
     * @param Advertisement $advertisement
     * @return Response
     */
    public function deleteAdvertisement(Request $request, Advertisement $advertisement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $advertisement->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $images= $em->getRepository(Image::class)->findAllByAdvertisement($advertisement);
            foreach($images as $image ){
                $nameFile=$image->getName();
                unlink($this->getParameter('advertisement_images_directory').'/'.$nameFile);

            }

            $em->remove($advertisement);
            $em->flush();
        }
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);


    }


    /**
     * @Route ("/{id}/favourite", name="favourite_advertisement")
     * @param Advertisement $advertisement
     * @param FavouriteAdvertisementRepository $advertisementRepository
     * @return Response
     */
    public function favouriteAdvertisement(Advertisement $advertisement, FavouriteAdvertisementRepository $advertisementRepository):Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if(!$user){
            return $this->json([
                'code'=>403,
                'message'=>'Unauthorized'
            ],403);
        }
        $em=$this->getDoctrine()->getManager();
        if($advertisement->isFavouritedByUser($user)){
            $favouriteAdvertisement=$advertisementRepository->findOneBy([
                'user'=>$user,
                'advertisement'=>$advertisement
            ]);
            $em->remove($favouriteAdvertisement);
            $em->flush();
            return $this->json([
                'code'=>'200',
                'message'=>'fovourite was deleted',
                'favouriteAdvertisement'=>$advertisementRepository->count(['advertisement'=>$advertisement])
                ],200);
        } else{
            $favouriteAdvertisement= new FavouriteAdvertisement();
            $favouriteAdvertisement->setUser($user);
            $favouriteAdvertisement->setAdvertisement($advertisement);
            $em->persist($favouriteAdvertisement);
            $em->flush();
        }
        return  $this->json([
            'code'=>200,
            'message'=> 'favourited',
            'favouriteAdvertisement'=> $advertisementRepository->count(['advertisement'=>$advertisement])],200);
    }

    /**
     * @Route("/delete/image/{id}", name="advertisement_delete_image", methods={"DELETE"})
     * @param Request $request
     * @param Image $image
     * @return JsonResponse
     */
    public function deleteImageFromAdvertisement(Request $request, Image $image): JsonResponse
    {
        $data=json_decode($request->getContent(),true);
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            $nameFile=$image->getName();
            //we delete the file
            unlink($this->getParameter('advertisement_images_directory').'/'.$nameFile);
            //we delete the file from database
            $em=$this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
            return new JsonResponse(['success'=>1]);
        }else{
            return new JsonResponse(['error'=>'Token Invalid'],400);
        }
        }
}
