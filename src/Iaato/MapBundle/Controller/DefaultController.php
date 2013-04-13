<?php

namespace Iaato\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    
	  require("GoogleMapAPI.class.php");
                $gmap = new GoogleMapAPI();
                $gmap->setDivId('test1');
                $gmap->setDirectionDivId('route');
                $gmap->setCenter('Nantes France');
                $gmap->setEnableWindowZoom(false);
				$gmap->setEnableAutomaticCenterZoom(true);
                $gmap->setDisplayDirectionFields(true);
                $gmap->setSize(600,600);
                $gmap->setZoom(11);
                // $gmap->setLang('en');
                $gmap->setDefaultHideMarker(false);

				// cat1
                $coordtab = array();
                $coordtab []= array('nantes france','<strong>html content</strong>');
                $coordtab []= array('carquefou france','<strong>html content</strong>');
                $coordtab []= array('vertou france','<strong>html content</strong>');
                $coordtab []= array('rezé france','<strong>html content</strong>');
				$gmap->setIconSize(20,34);
                $gmap->addArrayMarkerByAddress($coordtab,'cat1','markerpics.png');
				
				// cat2
                $coordtab = array();
                $coordtab []= array('saint-herblain france','<strong>html content</strong>');
                $coordtab []= array('bouguenais france','<strong>html content</strong>');
                $coordtab []= array('orvault france','<strong>html content</strong>');
                $gmap->addArrayMarkerByAddress($coordtab,'cat2');

                $gmap->generate();
                fopen("gmap.js", "w+");
        return $this->render('IaatoMapBundle:Default:index.html.twig',array($gmap="alert('ok');"));
    }
}
