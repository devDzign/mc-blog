<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MicroPostController
 *
 * @package App\Controller
 * @Route("/micro-post")
 */
class MicroPostController extends Controller
{
    
    /**
     * @Route("/", name="micro_post_index")
     */
    public function index()
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $this->getDoctrine()->getRepository(MicroPost::class)->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     */
    public function edit(MicroPost $microPost,Request $request)
    {
        $form =$this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return new RedirectResponse($this->generateUrl('micro_post_post',[
                'id'=> $microPost->getId()
            ]));
        }
        return $this->render('micro_post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request)
    {
        $microPost = new MicroPost();
        $microPost->setTime(new \DateTime());
        $form =$this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($microPost);
            $em->flush();
            return new RedirectResponse($this->generateUrl('micro_post_index'));
        }
        return $this->render('micro_post/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="micro_post_post")
     */
    public function post(MicroPost $microPost)
    {
        //$microPost =  $em = $this->getDoctrine()->getManager()->getRepository(MicroPost::class)->find($id);
        return $this->render('micro_post/post.html.twig', [
            'post' => $microPost,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     */
    public function delete(MicroPost $microPost)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($microPost);
        $em->flush();
        $this->addFlash('notice', 'Micro post was removed');
        return new RedirectResponse($this->generateUrl('micro_post_index'));
    }
}
