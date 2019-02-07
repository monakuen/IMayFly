<?php
/**
 * Created by PhpStorm.
 * User: camerlinckxjerome
 * Date: 17/01/19
 * Time: 10:35
 */

namespace CJ\IMayFlyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('CJIMayFlyBundle:Admin:index.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->render('CJIMayFlyBundle:Admin:delete.html.twig');
    }
}