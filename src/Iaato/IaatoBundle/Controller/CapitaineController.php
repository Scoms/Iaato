<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CapitaineController extends Controller
{
    public function indexAction()
    {
        return $this->render('IaatoIaatoBundle:Home:index.html.twig');
    }

}
