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
use Iaato\IaatoBundle\Entity\ContactMail;

class ContactController extends Controller
{
    public function indexAction()
    {
      $contactmail = new ContactMail();
      $formBuilder = $this->createFormBuilder($contactmail);
      $form = $formBuilder->getForm();
        return $this->render('IaatoIaatoBundle:Contact:index.html.twig',array(
            'content' => 'contact',
            'form' => $form->createView()
        ));
    }
    
    public function formAction()
    {
      
      $contactmail = new ContactMail();
      $formBuilder = $this->createFormBuilder($contactmail);
      $formBuilder
	->add('Nom',       'text')
	->add('Email',      'text')
	->add('Message',      'text');
      $form = $formBuilder->getForm();
      return $this->render('IaatoIaatoBundle:Contact:index.html.twig', array('form' => $form->createView()));
    
     //return $this->render('IaatoIaatoBundle:Home:index.html.twig',array('content' => 'home'));
    }
    
}

?>

