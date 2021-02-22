<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Image;
use App\Form\AdvertisementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route ("/{id}", name="advertisement_details", methods={"GET"}, requirements={"id"="\d+"})
     * @param Advertisement $advertisement
     * @return Response
     */
    public function showAdvertisementDetails(Advertisement $advertisement): Response
    {
        return $this->render('advertisement/advertisementDetails.html.twig', [
            'advertisement' => $advertisement
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

            return $this->redirectToRoute('default');
        }

        return $this->render('advertisement/edit.html.twig', [
            'advertisement' => $advertisement,
            '$advertisementForm' => $advertisementForm->createView(),
        ]);
    }


}
