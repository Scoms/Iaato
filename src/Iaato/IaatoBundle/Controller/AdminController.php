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

class AdminController extends Controller
{
	public function indexAction()
	{
	return $this->render('IaatoIaatoBundle:Admin:index.html.twig');
	}
}
?>

