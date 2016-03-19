<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends EasyAdminController
{
    /**
     * @Route("/", name="easyadmin")
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }
}
