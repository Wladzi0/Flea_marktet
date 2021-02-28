<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
//    /**
//     * @Route ("/advertisement/{id}/comment", name="new_comment", methods={"POST"}, requirements={"id"="\d+"})
//     * @param Request $request
//     * @param Advertisement $advertisement
//     * @return Response
//     */
    public function addComment(Request $request, Advertisement $advertisement): Response
    {
//        $advertisement= $this->getDoctrine()->getRepository(Advertisement::class)->find($request->get('id'));
//        $user = $this->get('security.token_storage')->getToken()->getUser();
//
//            $comment = $request->get('comment')->getData();
//            $comment->setUser($user);
//            $comment->setAdvertisement($advertisement);
//
//            $em= $this->getDoctrine()->getManager();
//            $em->persist($comment);
//            $em->flush();
//            return new Response();
//        $em= $this->getDoctrine()->getManager();
//        $commentRepo= $em->getRepository(Comment::class);
//        $lastComments=$commentRepo->findLastComments($advertisement);
//        return $this->render('advertisement/advertisementDetails.html.twig', [
//            'advertisement' => $advertisement,
//            'lastComments' => $lastComments,
//            'commentForm' => $commentForm->createView(),
//        ]);
    }

    /**
     * @Route ("/advertisement/{id}/comment", name="comment", methods={"POST"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param Advertisement $advertisement
     * @return Response
     */
    public function showAllAdvertComments(Request $request, Advertisement $advertisement): Response
    {
        $commentContent = $request->get('comment');
        $em= $this->getDoctrine()->getManager();
        if($commentContent){
         $comment=new Comment();
         $comment->setContent($commentContent);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $comment->setUser($user);

        $comment->setAdvertisement($advertisement);
        $em->persist($comment);
        $em->flush();
        }
        $comments=$em->getRepository(Comment::class)->findLastComments($advertisement);
        if($comments){
            $results['comments']=$this->getAllComments($comments);

        }
        return new Response(json_encode($results));
    }

    public function getAllComments($comments): array
    {
        foreach( $comments as $comment){
            $AllComments[$comment->getId()]=[$comment->getUser()->getFirstName(),$comment->getCreatedAt(),$comment->getContent()];
        }
        return $AllComments;
    }
}