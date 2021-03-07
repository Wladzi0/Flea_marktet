<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route ("/advertisement/{id}/addComment", name="new_comment", methods={"POST"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param Advertisement $advertisement
     * @return Response
     */
    public function addComment(Request $request, Advertisement $advertisement): Response
    {
        $commentContent = $request->get('comment');
        if($commentContent){
            $comment=new Comment();
            $comment->setContent($commentContent);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $comment->setUser($user);
            $em= $this->getDoctrine()->getManager();
            $comment->setAdvertisement($advertisement);
            $em->persist($comment);
            $em->flush();
            $result['comment']=[$comment->getUser()->getFirstName(),$comment->getCreatedAt(),$comment->getContent()];
        }
        return new Response(json_encode($result));

    }

    /**
     * @Route ("/advertisement/{id}/comment", name="comments", methods={"POST"}, requirements={"id"="\d+"})
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @param Advertisement $advertisement
     * @return Response
     */
    public function showAllAdvertComments(CommentRepository $commentRepository,Request $request, Advertisement $advertisement): Response
    {
        $comments=$commentRepository->findLastComments($advertisement);
        if($comments){
            $results['comments']=$this->getAllComments($comments);

        }
        return new Response(json_encode($results));
    }

    /**
     * @param $comments
     * @return array
     */
    public function getAllComments($comments): array
    {
        foreach( $comments as $comment){
            $AllComments[$comment->getId()]=[$comment->getUser()->getFirstName(),$comment->getCreatedAt(),$comment->getContent()];
        }
        return $AllComments;
    }


}
