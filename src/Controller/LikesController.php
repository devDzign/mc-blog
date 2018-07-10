<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class LikesController
 *
 * @package App\Controller
 * @Route("/likes")
 */
class LikesController extends Controller
{
    /**
     * @Route("/like/{id}", name="likes_like")
     */
    public function like(MicroPost $microPost)
    {

        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();

        if(!$currentUser instanceof  User){

            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }
//die('mourad flush');
        $microPost->addLikeBy($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['count'=> $microPost->getLikeBy()->count()],Response::HTTP_OK);
    }

    /**
     * @Route("/unlike/{id}", name="likes_unlike")
     */
    public function unlike(MicroPost $microPost)
    {
        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();

        if(!$currentUser instanceof  User){
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->removeLikeBy($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['count'=> $microPost->getLikeBy()->count()],Response::HTTP_OK);

    }
}
