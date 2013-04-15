<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;

class CSVDownController extends Controller
{
  public function indexAction()
  {  
    $repository = $this->getDoctrine()->getRepository('IaatoIaatoBundle:Activity'); 
    $query = $repository->createQueryBuilder('s'); 
    $query->orderBy('s.id', 'DESC'); 

    $data = $query->getQuery()->getResult(); 
    $filename = "export_".date("Y_m_d_His").".csv"; 

    $response = $this->render('IaatoIaatoBundle:CSV:download.html.twig'); 
    $response->headers->set('Content-Type', 'text/csv');

    $response->headers->set('Content-Disposition', 'attachment; filename='.$filename); 
    return $response; 
    
	//return $this->render('IaatoIaatoBundle:CSV:download.html.twig');
  }
}

?>
