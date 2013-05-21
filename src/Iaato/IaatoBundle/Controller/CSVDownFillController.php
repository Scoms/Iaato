<?php

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class CSVDownFillController extends Controller
{
  public function siteAction()
  {  
    $response = new Response();
    $repo_sites = $this->getDoctrine()->getManager()->getRepository('IaatoIaatoBundle:Site');
    $filename = "CSV/FILL/sites.csv";
    $fd = fopen($filename,"w+");
    $msg = "téléchargement ".$filename;
    $sites = $repo_sites->findAll();
    fputs($fd,"name site;\n");
    foreach($sites as $site)
    {
      fputs($fd,$site->getNameSite().";\n");
    }
    fputs($fd,'\0');
    
    $response->setContent(file_get_contents($filename));
    $response->headers->set('Content-Type', 'application/force-download'); // modification du content-type pour forcer le téléchargement (sinon le navigateur internet essaie d'afficher le document)
    $response->headers->set('Content-disposition', 'filename='. $filename);
    return $response;
  }
}