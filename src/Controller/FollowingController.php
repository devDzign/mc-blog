<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FollowingController
 *
 * @package App\Controller
 * @Security("is_granted('ROLE_USER')")
 * @Route("/following")
 */
class FollowingController extends Controller
{
    /**
     * @Route("/follow/{id}", name="follow")
     */
    public function follow(User $user)
    {

        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();

        if($currentUser->getId() !== $user->getId() ){
            $currentUser->getFollowing()->add($user);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('micro_post_user',
            ['username'=>$user->getUsername()]);
    }

    /**
     * @Route("/unfollow/{id}", name="unfollow")
     */
    public function unfollow(User $user)
    {
        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();
        $currentUser->getFollowing()->removeElement($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('micro_post_user',
            ['username'=>$user->getUsername()]);
    }
}
