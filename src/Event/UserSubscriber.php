<?php
/**
 * Created by PhpStorm.
 * User: MCH3730
 * Date: 10/07/2018
 * Time: 18:23
 */

namespace App\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig_Environment;

    /**
     * UserSubscriber constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig_Environment
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig_Environment)
    {
        $this->mailer = $mailer;
        $this->twig_Environment = $twig_Environment;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $userRegisterEvent)
    {
        $user = $userRegisterEvent->getRegisterUser();
        $template = $this->twig_Environment->render('email/register.html.twig', ['user' => $user]);
        $message = (new \Swift_Message())
            ->setSubject('Welcome to mini tweeter App!!')
            ->setFrom('micro-post@micropost.com')
            ->setTo($user->getEmail())
            ->setBody($template, 'text/html');

        $this->mailer->send($message);
    }
}