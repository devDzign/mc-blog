<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\Notification;
use App\Entity\User;
use App\Repository\NotificationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class NotificatioController
 *
 * @package App\Controller
 * @Route("/notification")
 * @Security("is_granted('ROLE_USER')")
 */
class NotificationController extends Controller
{
    /**
     * @var \App\Repository\NotificationRepository
     */
    private $notificationRepository;

    /**
     * NotificationController constructor.
     *
     * @param \App\Repository\NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
     {
         $this->notificationRepository = $notificationRepository;
     }

    /**
     * @Route("/unread-count", name="notification_unread")
     */
    public function unreadCount()
    {
        return new JsonResponse(
            [
                'count'=> $this->notificationRepository->findUnseenByUser($this->getUser())
            ]
        );
    }

    /**
     * @Route("/all", name="notification_all")
     */
    public function notifications()
    {
        return $this->render('notification/notifications.html.twig', [
            'notifications' => $this->notificationRepository->findBy([
                'seen' => false,
                'user' => $this->getUser()
            ])
        ]);
    }

    /**
     * @Route("/acknowledge/{id}", name="notification_acknowledge")
     */
    public function acknowledge(Notification $notification)
    {
        $notification->setSeen(true);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('notification_all');
    }

    /**
     * @Route("/acknowledge-all", name="notification_acknowledge_all")
     */
    public function acknowledgeAll()
    {
        $this->notificationRepository->markAllAsReadByUser($this->getUser());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('notification_all');
    }



}
