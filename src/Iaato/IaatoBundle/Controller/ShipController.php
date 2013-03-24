<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * Ship.php
 *
 * @author
 * @date 2013/03/24
 * @link
 */

namespace Iaato\IaatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;

class ShipController extends Controller {

	public function indexAction(){
	
		return $this->render('IaatoIaatoBundle:Secretariat:ship.html.twig');
	
	}

}

?>

