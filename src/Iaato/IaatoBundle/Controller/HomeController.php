<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * HomeController.php
 *
 * @author
 * @date 2013/03/13
 * @link
 */

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
public function indexAction()
{
return $this->render('IaatoIaatoBundle:Home:index.html.twig',array('content' => 'home'));
}
/*
    public function formAction()
    {
      
      $article = new Article();
      $formBuilder = $this->createFormBuilder($article);
      $formBuilder
	->add('titre',       'text')
	->add('auteur',      'text');
      $form = $formBuilder->getForm();
      return $this->render('IaatoIaatoBundle:Home:index.html.twig', array('form' => $form->createView()));
    
     //return $this->render('IaatoIaatoBundle:Home:index.html.twig',array('content' => 'home'));
    }*/
    
}
?>

