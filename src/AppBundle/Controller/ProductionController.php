<?php
// src/AppBundle/Controller/ProductionController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Production;
use AppBundle\Form\ProductionType;
use AppBundle\Entity\Nomenclature;
use AppBundle\Form\NomenclatureType;
use BG\BarcodeBundle\Util\Base1DBarcode as barCode;

class ProductionController extends Controller
{
    /****************************************
    **
    ** ACCUEIL PRODUCTION
    **
    ****************************************/
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Production');

        $listeprodencours = $repository->getProductionEnCours();

    	return $this->render('AppBundle:Production:index.html.twig', array('listeprodencours' => $listeprodencours));
    }


    /****************************************
    **
    ** MENU PRODUCTION
    **
    ****************************************/
    public function menuAction()
    {
        return $this->render('AppBundle:Production:menu.html.twig');
    }
	

    /****************************************
    **
    ** GESTION DES BONS A TIRER
    **
    ****************************************/
	public function bonAction()
    {
		$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Produits');

		$listeproduit = $repository->getListeProduits();

		return $this->render('AppBundle:Production:bon.html.twig', array('listeproduit' => $listeproduit) );
	}
		
    public function renduAction(Request $request)
    {
    	$code = $request->request->get('code');
        $codeinterne = $code.date('ymdHi');
        $id = $request->request->get('id');

    	$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Nomenclature');

        $listenomenclature = $repository->getNomenclature($code);

        //codes barres
        $cb = new barCode();
        $cb->savePath = 'upload/codebarre/';

        $cb_rendu_commercial = $cb->getBarcodePNGPath($code, 'C128', 1.75, 45);
        $cb_rendu_interne = $cb->getBarcodePNGPath($codeinterne, 'C128', 1.75, 45);

        return $this->render('AppBundle:Production:bonajax.html.twig', array(
                'listenomenclature' => $listenomenclature,
                'cb_commercial' => $cb_rendu_commercial, 
                'cb_interne' => $cb_rendu_interne,
                'code' => $code,
                'code_interne' => $codeinterne,
                'idt' => $id,
        ));
    }
	

    /****************************************
    **
    ** GESTION DES BONS A JETER
    **
    ****************************************/
	public function rebutAction()
    {
        return $this->render('AppBundle:Production:rebut.html.twig');
    }

    public function resultat_rebutAction(Request $request)
    {
        $code = $request->request->get('codeInterne');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Production');
        
        //demande liste des production en rebut
        if( $code == "*")
        {
            $listeproduction = $repository->getProductionRebut();

            return $this->render('AppBundle:Production:rebutajax.html.twig', array('listeproduction' => $listeproduction, 'choix' => true) );
        }
        else
        {
            $listeproduction = $repository->getProductionLigneRebut($code);   

            return $this->render('AppBundle:Production:rebutajax.html.twig', array('listeproduction' => $listeproduction, 'choix' => false) );
        }
    }

    public function rendu_rebutAction(Request $request)
    {
        $id = $request->request->get('id');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Production');

        $production = $repository->getProductionParIdt($id);

        //IdtElement_codeProduit_idmotif_aammjjhhmm
        $codeinterne = $production[0]->getIdtElement()."_".$production['codeProduit']."_".$production['nomRebu']."_".$production[0]->getDateDebut()->format('ymdHi');

        //codes barres
        $cb = new barCode();
        $cb->savePath = 'upload/codebarre/';
        $cb_rendu_interne = $cb->getBarcodePNGPath($codeinterne, 'C128', 1.75, 45);

        return $this->render('AppBundle:Production:bonrebut.html.twig', array(
                'production' => $production,
                'cb_interne' => $cb_rendu_interne,
        ));
    }
	

    /****************************************
    **
    ** SUIVI PRODUCTION
    **
    ****************************************/
	public function suiviAction()
    {
    	return $this->render('AppBundle:Production:suivi.html.twig');
    }

    public function resultatAction(Request $request)
    {
    	$code = $request->request->get('codeInterne');

    	$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Production');
           
        $listeproduction = $repository->getProductionCode($code);  	

        return $this->render('AppBundle:Production:suiviajax.html.twig', array('listeproduction' => $listeproduction) );
    }
	

    /****************************************
    **
    ** GESTION DES PRODUITS FINIS
    **
    ****************************************/
	public function etiquetteAction()
    {
        return $this->render('AppBundle:Production:etiquette.html.twig');
    }

    public function resultat_etiquetteAction(Request $request)
    {
        $code = $request->request->get('codeInterne');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Production');
        
        //demande liste des production en rebut
        if( $code == "*")
        {
            $listeproduction = $repository->getProductionFinie();

            return $this->render('AppBundle:Production:etiquetteajax.html.twig', array('listeproduction' => $listeproduction, 'choix' => true) );
        }
        else
        {
            $listeproduction = $repository->getProductionLigneFinie($code);   

            return $this->render('AppBundle:Production:etiquetteajax.html.twig', array('listeproduction' => $listeproduction, 'choix' => false) );
        }
    }

    public function rendu_etiquetteAction(Request $request)
    {
        $id = $request->request->get('id');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Production');

        $production = $repository->getProductionParIdt($id);

        //code commercial (voir bon à tirer)
        $codecommercial = substr($production[0]->getCodeInterne(), 0, 15);

        //codes barres
        $cb = new barCode();
        $cb->savePath = 'upload/codebarre/';
        $cb_rendu_commercial = $cb->getBarcodePNGPath($codecommercial, 'C128', 1.75, 45);

        return $this->render('AppBundle:Production:bonfinal.html.twig', array(
                'production' => $production,
                'cb_commercial' => $cb_rendu_commercial,
        ));
    }
}