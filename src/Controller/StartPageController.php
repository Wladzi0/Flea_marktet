<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Category;
use App\Entity\Subcategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('start_page/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/search", name="search_posts", methods={"GET"})
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
}
