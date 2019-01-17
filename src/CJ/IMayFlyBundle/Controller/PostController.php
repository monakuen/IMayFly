<?php
/**
 * Created by PhpStorm.
 * User: camerlinckxjerome
 * Date: 10/01/19
 * Time: 11:22
 */

namespace CJ\IMayFlyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PostController extends Controller
{
    public function indexAction()
    {
        return $this->render('CJIMayFlyBundle:Post:index.html.twig');
    }

    public function viewAction($id)
    {
        return $this->render('CJIMayFlyBundle:Post:view.html.twig',['id'=>$id]);
    }

    public function addAction(Request $request)
    {
        if($request->isMethod('POST')){
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('CJ_IMayFly_view');
        }

        return $this->render('CJIMayFlyBundle:Post:add.html.twig');
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
}