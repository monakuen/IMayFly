<?php
/**
 * Created by PhpStorm.
 * User: camerlinckxjerome
 * Date: 17/01/19
 * Time: 10:35
 */

namespace CJ\IMayFlyBundle\Controller;

use CJ\IMayFlyBundle\Entity\Post;
use CJ\IMayFlyBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $listUsers = $em->getRepository('CJUserBundle:User')->findBy(
            array(),                            // Critere
            array(),                            // Tri
            9,                             // Limite
            null
        );

        $listPosts = $em->getRepository('CJIMayFlyBundle:Post')->findBy(
            array(),                            // Critere
            array('date' => 'desc'),            // Tri
            9,                             // Limite
            null
        );

        $posts = $this->get('knp_paginator')->paginate(
            $listPosts,
            $request->query->get('page_post', $page),
            5
        );

        $users = $this->get('knp_paginator')->paginate(
            $listUsers,
            $request->query->get('page_user', $page),
            5
        );

        return $this->render('CJIMayFlyBundle:Admin:index.html.twig', array(
            'posts' => $posts,
            'users' => $users
        ));
    }

    public function deletePostAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->find('CJIMayFlyBundle:Post', $id);

        if($request->isMethod('POST')) {
            $em->remove($post);
            $em->flush();

            return $this->redirectToRoute('CJ_IMayFly_admin');
        }
        return $this->render('CJIMayFlyBundle:Admin:delete.html.twig',array(
            'post' => $post,
        ));
    }

    public function searchAction(Request $request, $page)
    {
        $searchInput = $request->get('search-input');
        $listPosts = $this->getDoctrine()->getManager()->getRepository('CJIMayFlyBundle:Post')->createQueryBuilder('cj')
            ->where('cj.title LIKE :title ')
            ->orWhere('cj.tags LIKE :tags ')
            ->orWhere('cj.category LIKE :category')
            ->setParameter('title', '%'.$searchInput.'%')
            ->setParameter('tags', '%'.$searchInput.'%')
            ->setParameter('category', '%'.$searchInput.'%')
            ->getQuery()
            ->getResult();
        $posts = $this->get('knp_paginator')->paginate(
            $listPosts,
            $request->query->get('page', $page),
            5
        );
        return $this->render('CJIMayFlyBundle:Admin:search.html.twig', array(
            'posts' => $posts
        ));
    }


    public function deleteUserAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->find('CJUserBundle:User', $id);

        if($request->isMethod('POST')) {
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('CJ_IMayFly_admin');
        }
        return $this->render('CJIMayFlyBundle:Admin:delete.html.twig',array(
            'user' => $user,
        ));
    }


}