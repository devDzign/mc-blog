<?php

namespace App\Controller;

use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 *
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @var \App\Service\Greeting
     */
    private $greeting;

    /**
     * BlogController constructor.
     *
     * @param \App\Service\Greeting $greeting
     */
    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     * @Route("/", name="blog", requirements={})
     */
    public function index(Request $request)
    {


      $this->get('mailer')->
        $url = $this->generateUrl('blog', ['page'=> 1]);
       var_dump($url);
        die;
        return $this->render(
            'base.html.twig'
        );
    }
}
