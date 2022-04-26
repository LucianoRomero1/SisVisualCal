<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
        return $this->render('default/index.html.twig');
    }
}
