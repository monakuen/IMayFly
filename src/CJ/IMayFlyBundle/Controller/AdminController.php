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

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('CJIMayFlyBundle:Admin:index.html.twig');
    }
}