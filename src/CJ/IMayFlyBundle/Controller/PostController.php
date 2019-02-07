<?php
/**
 * Created by PhpStorm.
 * User: camerlinckxjerome
 * Date: 10/01/19
 * Time: 11:22
 */

namespace CJ\IMayFlyBundle\Controller;

use CJ\IMayFlyBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PostController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('CJIMayFlyBundle:Post')->findBy(
            array(),                            // Critere
            array('date' => 'desc'),            // Tri
            null,                             // Limite
            null
        );
//        $adverts = $this->get('knp_paginator')->paginate(
//            $listAdverts,
//            $request->query->get('page', $page),
//            3
//        );
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
            'post' => $post
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $post = new Post();
        $post->setUser('1');
        $post->setImage('mkljhlgkhopihfhhjkhmpihpmj');
        $post->setTitle('Mario');
        $post->setCategory('screenshot');
        $post->setTags('Luigi super mario');
        $post->setDescription('Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

        $em = $this->getDoctrine()->getManager();

        $em->persist($post);

        $em->flush();

        if($request->isMethod('POST')){
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('CJ_IMayFly_view', array('id' => $post->getId()));
        }

        return $this->render('CJIMayFlyBundle:Post:add.html.twig', array('post' => $post));
    }

    public function editAction($id ,Request $request)
    {
        if($request->isMethod('POST')){
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirectToRoute('CJ_IMayFly_view', array('id' => $id));
        }

        return $this->render('CJIMayFlyBundle:Post:edit.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->render('CJIMayFlyBundle:Post:delete.html.twig');
    }

    public function userAction($id)
    {
        return $this->render('CJIMayFlyBundle:Post:user.html.twig');
    }

    public function termsAction()
    {
        return $this->render('CJIMayFlyBundle:Post:terms.html.twig');
    }
}