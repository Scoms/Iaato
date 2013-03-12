<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8
/**
 * BlogController.php
 *
 * @author
 * @date 2013/03/05
 * @link
 */

// src/Sdz/BlogBundle/Controller/BlogController.php
 
namespace Sdz\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
 
class BlogController extends Controller
{
  	public function indexAction()
  	{
	return $this->render('SdzBlogBundle:Blog:index.html.twig',array('nom' => 'Scoms'));  
	$id=6;
	$url = $this->generateUrl('sdzblog_voir',array('id' => $id));
	return $this->redirect($url);
	}	
	public function voirAction($id)
	{
		return new Response("Affiche de l'article d'identifiant : ".$id.".");
	}
	public function voirSlugAction($slug,$annee,$format)
	{
		return new Response("On pourrait afficher l'article correspondant au slug '".$slug."', crée en ".$annee." et au format ".$format.".");
	}
}

?>
