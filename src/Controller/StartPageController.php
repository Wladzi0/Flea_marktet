<?php

namespace App\Controller;

use App\Entity\Category;
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
    public function index(): Response
    {   
        return $this->render('start_page/index.html.twig', [
            'controller_name' => 'StartPageController',
        ]);
    }

    /**
     * @Route("/search", name="searchPosts", methods={"GET"}) 
    */

    public function searchPosts(Request $request){
       $em= $this->getDoctrine()->getManager();
       $requestString = $request->get('search');
       $posts= $em->getRepository(Category::class)->findEntityByString($requestString);
           if(!$posts){
               $result['posts']['error']="Advertisement not found ;(";
               }
               else{
                   $result['posts']=$this->getRealEntity($posts);
               }
        return new Response(json_encode($result));
       }


    public function getRealEntity($posts){
        foreach( $posts as $post){
            $realEntities[$post->getId()]=[$post->getName()];
        }
        return $realEntities;
    }
}
