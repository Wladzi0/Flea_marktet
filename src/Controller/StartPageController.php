<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Advertisement;
use App\Entity\Category;
use App\Entity\Subcategory;
use App\Form\SearchForm;
use App\Repository\AdvertisementRepository;
use App\Repository\SubcategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @IsGranted ("ROLE_USER")
 *
 */
class StartPageController extends AbstractController
{
    /**
     * @Route("/", name="start_page")
     * @param AdvertisementRepository $advertisementRepository
     * @param Request $request
     * @return Response
     */
    public function index(AdvertisementRepository $advertisementRepository, Request $request): Response
    {
        $data = new SearchData();
        $searchForm = $this->createForm(SearchForm::class, $data);
        [$min, $max] = $advertisementRepository->findMinMax($data);
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->FindAll();
        $lastAdvertisements = $advertisementRepository->findAdvertisements();
        return $this->render('start_page/index.html.twig', [
            'categories' => $categories,
            'lastAdvertisements' => $lastAdvertisements,
            'searchForm' => $searchForm->createView(),
            'min'=>$min,
            'max'=>$max
        ]);
    }

    /**
     * @Route("/search", name="search_advertisements", methods={"GET"})
     * @param AdvertisementRepository $advertisementRepository
     * @param Request $request
     * @return Response
     */

    public function searchPosts(AdvertisementRepository $advertisementRepository, Request $request): Response
    {
        $requestString = $request->get('search');
        $posts = $advertisementRepository->findEntityByString($requestString);
        if (!$posts) {
            $result['posts']['error'] = "Advertisement not found ;(";
        } else {
            $result['posts'] = $this->getRealEntity($posts);
        }
        return new Response(json_encode($result));
    }

    /**
     * @param $posts
     * @return array
     */
    public function getRealEntity($posts): array
    {
        foreach ($posts as $post) {
            $realEntities[$post->getId()] = [$post->getName()];
        }
        return $realEntities;
    }

    /**
     * @Route("/searchByCategory", name="search_by_category", methods={"GET"})
     * @param SubcategoryRepository $subcategoryRepository
     * @param Request $request
     * @return Response
     */
    public function searchSubcategory(SubcategoryRepository $subcategoryRepository, Request $request): Response
    {
        $requestCategory = $request->get('searchByCategory');

        $subcategories = $subcategoryRepository->findById($requestCategory);
        if (!$subcategories) {
            $result['subcategories']['error'] = "Subcategories not found ;(";
        } else {
            $result['subcategories'] = $this->getSubcategories($subcategories);
        }
        return new Response(json_encode($result));
    }

    /**
     * @param $subcategories
     * @return array
     */
    public function getSubcategories($subcategories): array
    {
        foreach ($subcategories as $subcategory) {
            $getSubcategory[$subcategory->getId()] = [$subcategory->getName()];
        }
        return $getSubcategory;
    }

    /**
     * @Route ("/advertisementsInSub/{id}", name="advertisementsInSub", methods={"GET"})
     * @param AdvertisementRepository $advertisementRepository
     * @param Request $request
     * @return Response
     */
    public function advertisementsInSub(AdvertisementRepository $advertisementRepository, Request $request): Response
    {
        $subcategory = $request->get('id');

        if ($subcategory) {
            $advertisements = $advertisementRepository->findPostBySubcategory($subcategory);
        }

        return $this->render('advertisement/index.html.twig', [
            'advertisements' => $advertisements,
        ]);
    }

    /**
     * @Route ("/searchAllMatches", name="search_all_matches", methods={"GET"})
     * @param AdvertisementRepository $advertisementRepository
     * @param Request $request
     * @return Response
     */
    public function searchAction(AdvertisementRepository $advertisementRepository, Request $request): Response
    {
        $requestString = $request->get('search');
        $requestStringCity = $request->get('place');
        if ($requestString) {
            $searchingResults = $advertisementRepository->findAdvertisementsByString($requestString);
        }
        if ($requestStringCity) {
            $searchingResults = $advertisementRepository->findAdvertisementsByLocation($requestStringCity);
        }


        return $this->render('advertisement/searchingPage.html.twig', [
            'advertisements' => $searchingResults,
            'searchingString' => $requestString
        ]);
    }

    /**
     * @Route ("/searchAllMatchesLocation", name="search_all_matches_location", methods={"GET"})
     * @param AdvertisementRepository $advertisementRepository
     * @param Request $request
     * @return Response
     */
    public function searchByLocation(AdvertisementRepository $advertisementRepository,Request $request): Response
    {
        $requestString = $request->get('searchLocation');

        $locations = $advertisementRepository->findAdvertisementsByLocation($requestString);
        if (!$locations) {
            $result['locations']['error'] = "Location not found :(";
        } else {
            $result['locations'] = $this->getRealLocation($locations);
        }
        return new Response(json_encode($result));
    }

    /**
     * @param $locations
     * @return array
     */
    public function getRealLocation($locations): array
    {
        foreach ($locations as $location) {
            $realLocation[$location->getId()] = [$location->getLocation()];
        }
        return $realLocation;
    }

}
