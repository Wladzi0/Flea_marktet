<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StartPageController extends AbstractController
{
    /**
     * @Route("/", name="start_page")
     * 
     */
    public function index(): Response
    {   
        return $this->render('start_page/index.html.twig', [
            'controller_name' => 'StartPageController',
        ]);
    }

    /**
     * @Route("/search", name="searchPosts", methods={"GET"}) 
    */

    public function searchAutocomplete(Request $request){
       $em= $this->getDoctrine()->getManager();
       $requestString = $request->get('q');
       $posts= $em->getRepository(Category::class)->findEntityByString($requestString);
       if(!$posts){
           if(!$posts){
               $result['posts']['error']="Post not found ;(";
               }
               else{
                   $result['posts']=$this->getRealEntity($posts);
               }
        return new Response(json_encode($result));
       }
    }

    public function getRealEntity($posts){
        foreach( $posts as $post){
            $realEntities[$posts->getId()]=[$posts->getName()];
        }
        return $getRealEntities;
    }
}
