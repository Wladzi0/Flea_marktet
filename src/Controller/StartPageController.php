<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Category;
use App\Entity\Subcategory;
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
     * 
     */
    public function index(Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $categories =$em->getRepository(Category::class)->FindAll();
        $advertisementRepo = $em->getRepository(Advertisement::class);
        $lastAdvertisements = $advertisementRepo->findAdvertisements();
        return $this->render('start_page/index.html.twig', [
            'categories' => $categories,
            'lastAdvertisements' => $lastAdvertisements,
        ]);
    }

    /**
     * @Route("/search", name="search_advertisements", methods={"GET"})
     * @param Request $request
     * @return Response
     */

    public function searchPosts(Request $request): Response
    {
       $em= $this->getDoctrine()->getManager();
       $requestString = $request->get('search');
       $posts= $em->getRepository(Advertisement::class)->findEntityByString($requestString);
           if(!$posts){
               $result['posts']['error']="Advertisement not found ;(";
               }
               else{
                   $result['posts']=$this->getRealEntity($posts);
               }
        return new Response(json_encode($result));
       }


    public function getRealEntity($posts): array
    {
        foreach( $posts as $post){
            $realEntities[$post->getId()]=[$post->getName()];
        }
        return $realEntities;
    }

    /**
     * @Route("/searchByCategory", name="search_by_category", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function searchSubcategory(Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $requestCategory=$request->get('searchByCategory');

        $subcategories=$em->getRepository(SubCategory::class)->findById($requestCategory);
        if(!$subcategories){
            $result['subcategories']['error']="Subcategories not found ;(";
        }
        else{
            $result['subcategories']=$this->getSubcategories($subcategories);
        }
        return new Response(json_encode($result));
    }

    public function getSubcategories($subcategories): array
    {
        foreach( $subcategories as $subcategory){
            $getSubcategory[$subcategory->getId()]=[$subcategory->getName()];
        }
        return $getSubcategory;
    }

    /**
     * @Route ("/advertisementsInSub/{id}", name="advertisementsInSub", methods={"GET"})
     *
     */
    public function advertisementsInSub(Request $request): Response
    {

             $subcategory=$request->get('id');

        if($subcategory){
            $advertisements =$this->getDoctrine()->getRepository(Advertisement::class)->findPostBySubcategory($subcategory);
        }

        return $this-> render('advertisement/index.html.twig',[
            'advertisements'=>$advertisements,
        ]);
    }
    /**
     * @Route ("/searchAllMatches", name="search_all_matches", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function searchAction(Request $request): Response
    {
        $requestString = $request->get('search');
        $requestStringCity=$request->get('place');
        $em = $this->getDoctrine()->getManager();
        if($requestString){
            $searchingResults = $em->getRepository(Advertisement::class)->findAdvertisementsByString($requestString);
        }
        if($requestStringCity){
            $searchingResults = $em->getRepository(Advertisement::class)->findAdvertisementsByLocation($requestStringCity);
        }


        return $this->render('advertisement/searchingPage.html.twig', [
            'advertisements' => $searchingResults,
            'searchingString'=> $requestString
        ]);
    }

    /**
     * @Route ("/searchAllMatchesLocation", name="search_all_matches_location", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function searchByLocation(Request $request): Response
    {
        $requestString = $request->get('searchLocation');
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository(Advertisement::class)->findAdvertisementsByLocation($requestString);
        if(!$locations){
            $result['locations']['error']="Location not found :(";
        }
        else{
            $result['locations']=$this->getRealLocation($locations);
        }
        return new Response(json_encode($result));
    }
    public function getRealLocation($locations): array
    {
        foreach( $locations as $location){
            $realLocation[$location->getId()]=[$location->getLocation()];
        }
        return $realLocation;
    }

}
