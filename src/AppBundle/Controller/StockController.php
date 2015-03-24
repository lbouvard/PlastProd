<?php

// src/AppBundle/Controller/StockController.php

namespace AppBundle\Controller;

//use AppBundle\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Produits;
use AppBundle\Entity\Stock;
use AppBundle\Entity\Societe;
use AppBundle\Form\SocieteType;
use AppBundle\Form\ProduitsType;

class StockController extends Controller
{
    public function indexAction(){

    	$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Stock');

		$listestock = $repository->getListeStock();

    	return $this->render('AppBundle:Stock:index.html.twig', array('listestock' => $listestock));
    }

    public function menuAction(Request $request)
    {
	    return $this->render('AppBundle:Stock:menu.html.twig');
    }

	public function fournisseurAction(){
		
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Societe');
		
		$listefournisseur = $repository->getListeFournisseur2();
		
		return $this->render('AppBundle:Stock:fournisseur.html.twig', array('listefournisseur' => $listefournisseur) );
	}

	public function ajoutFournisseurAction(Request $request){

        $fournisseur = new Societe('F');

        $form = $this->createForm(new SocieteType(), $fournisseur);

        if ($form->handleRequest($request)->isValid()) {

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($fournisseur);
        	$em->flush();

        	$request->getSession()->getFlashBag()->add('notice', 'Le fournisseur a été créé avec succès.');

          	// On redirige vers la page de visualisation de l'annonce nouvellement créée
          	return $this->redirect($this->generateUrl('gerer_fournisseur'));
        }

        return $this->render('AppBundle:Stock:addfournisseur.html.twig', array(
          	'form' => $form->createView(),
        ));
	}

	public function modifieFournisseurAction($id, Request $request){

    	$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Societe');
        
        $fournisseur = $repository->getSocieteParId($id);

        $form = $this->createForm(new SocieteType(), $fournisseur);

        if ($form->handleRequest($request)->isValid()) {

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($fournisseur);
        	$em->flush();

        	$request->getSession()->getFlashBag()->add('notice', 'Le fournisseur a été modifié avec succès.');

          	// On redirige vers la page de visualisation de l'annonce nouvellement créée
          	return $this->redirect($this->generateUrl('gerer_fournisseur'));
        }

        return $this->render('AppBundle:Stock:modifiefournisseur.html.twig', array(
          	'form' => $form->createView(),
        ));
	}

	public function ajoutStockAction(Request $request){

		$produit = new Produits();

		$form = $this->createForm( new ProduitsType(), $produit, array('produit_fournisseur' => false) );
	
		if( $form->handleRequest($request)->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($produit);

			$stock = new Stock();
			$stock->setQuantite($produit->getQuantite());
			$stock->setProduit($produit);
			$em->persist($stock);

			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Le produits a été ajouté et le stock modifié.');
			if( $produit->getProducteur()->getTypeSociete() == 'M')
				$request->getSession()->getFlashBag()->add('info', 'Pensez à créer la nomenclature.');

			return $this->redirect($this->generateUrl('accueil_stock'));
		}				
				
		return $this->render('AppBundle:Stock:ajoutstock.html.twig', array('form' => $form->createView()));
	}

	public function modifieStockAction(){
    	
    	$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Stock');

		$listestock = $repository->getListeStock();	
		
		return $this->render('AppBundle:Stock:modifiestock.html.twig', array('listestock' => $listestock) );
	}

	public function variationStockAction(Request $request){

		$id = $request->request->get('id');
		$quantite = $request->request->get('quantite');
		$prix = $request->request->get('prix');

		$em = $this->getDoctrine()->getManager();

    	$repository = $em->getRepository('AppBundle:Stock');
		$stock = $repository->getLigneStock($id);

		$stock->setQuantite($quantite);
		$stock->getProduit()->setPrixProduit($prix);

		$em->persist($stock);
		$em->flush();

		$request->getSession()->getFlashBag()->add('notice', 'Le stock a été modifié.');

		return $this->render('AppBundle:Stock:flash.html.twig');
	}
}