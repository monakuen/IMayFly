<?php
/**
 * Created by PhpStorm.
 * User: camerlinckxjerome
 * Date: 10/01/19
 * Time: 11:22
 */

namespace CJ\IMayFlyBundle\Controller;

use CJ\IMayFlyBundle\Entity\Post;
use CJ\IMayFlyBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class PostController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $listPosts = $em->getRepository('CJIMayFlyBundle:Post')->findBy(
            array(),                            // Critere
            array('date' => 'desc'),            // Tri
            null,                             // Limite
            null
        );
        $posts = $this->get('knp_paginator')->paginate(
            $listPosts,
            $request->query->get('page', $page),
            9
        );
        return $this->render('CJIMayFlyBundle:Post:index.html.twig', array(
            'posts' => $posts
        ));
    }

    public function viewAction($id)
    {
        if($id<1){
            throw new NotFoundHttpException("la page est inexistante");
        }
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CJIMayFlyBundle:Post')
        ;

        $post = $repository->find($id);

        if (null === $post) {
            throw new NotFoundHttpException("La page d'id ".$id." n'existe pas.");
        }

        return $this->render('CJIMayFlyBundle:Post:view.html.twig', array(
            'post' => $post,
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        $post = new Post();

        $form = $this->get('form.factory')->create(PostType::class, $post);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $user = $this->getUser();
            $post->setUser($user);

            $post->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Post bien enregistrée.');

            return $this->redirectToRoute('CJ_IMayFly_view', array('id' => $post->getId()));
            }

        return $this->render('CJIMayFlyBundle:Post:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id ,Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CJIMayFlyBundle:Post')
        ;

        $post = $repository->find($id);

        $form = $this->get('form.factory')->create(PostType::class, $post);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $post->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Post bien modifié.');

            return $this->redirectToRoute('CJ_IMayFly_view', array('id' => $post->getId()));
        }

        return $this->render('CJIMayFlyBundle:Post:edit.html.twig',array(
            'form' => $form->createView(),
            'post' => $post,
        ));
    }

    public function deleteAction($id ,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->find('CJIMayFlyBundle:Post', $id);

        if($request->isMethod('POST')) {
            $em->remove($post);
            $em->flush();

            return $this->redirectToRoute('CJ_IMayFly_home');
        }
        return $this->render('CJIMayFlyBundle:Post:delete.html.twig',array(
            'post' => $post,
        ));
    }

    public function userAction(Request $request, $page, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $listPosts = $em->getRepository('CJIMayFlyBundle:Post')->findBy(
            array('user' => $id),
            array('date' => 'desc'),
            null,
            null
        );

        $posts = $this->get('knp_paginator')->paginate(
            $listPosts,
            $request->query->get('page', $page),
            9
        );

        $user = $em->getRepository('CJUserBundle:User')->findOneBy(array('id' => $id));
//
        return $this->render('CJIMayFlyBundle:Post:user.html.twig', array(
            'posts' => $posts,
            'user' => $user
        ));
    }

    public function termsAction()
    {
        return $this->render('CJIMayFlyBundle:Post:terms.html.twig');
    }
}