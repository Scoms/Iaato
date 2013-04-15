<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Iaato\IaatoBundle\Entity\Society;
use Symfony\Component\Security\Core\SecurityContext;

class CSVUpController extends Controller
{
  public function indexAction()
  {
	  $form = $this->createFormBuilder()
		->add('file', 'file')
		->getForm();

		$request = $this->get('request');


		// Check if we are posting stuff
		if ($request->getMethod() == 'POST') {
			
			$form->bind($request);
			
			if ($form->isValid()) {
				
				
				$file = $form->get('file');
                $filename = $form->getOriginalName();
//                list($filename, $extension) = explode('.', $file);

				// Your csv file here when you hit submit button
				$fichier = file($file->getData());
				
				$response = $this->forward('IaatoIaatoBundle:CSVUp:show', array('file'  => $fichier , 'filename' => $filename));
				return $response;
				//return $this->redirect($this->generateUrl('iaato_csv_show', array('file' => $fichier)));
				//return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('data' => 'test'));
			}
		}
		return $this->render('IaatoIaatoBundle:CSV:upload.html.twig', array('form' => $form->createView()));
  }
  
  public function showAction($file, $filename)
  {
	$total = count($file);
	$data = array();

	for($i = 1; $i < $total; $i++){
		$lin = $file[$i];
		list($varA, $varB) = explode(';', $lin);
		$data[] = array($varA, $varB);
	}
	
	return $this->render('IaatoIaatoBundle:CSV:show.html.twig', array('data' => $data , 'filename' => $filename));
  }
  
}

?>
