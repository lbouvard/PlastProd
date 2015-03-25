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

			//on ajoute autant de ligne que de quantité demandé du produit
			for ($i = 0; $i < $produit->getQuantite(); $i++) 
			{
				$stock = new Stock();

				$stock->setDateEntree(new \DateTime());
				$stock->setProduit($produit);

				$em->persist($stock);
			}

			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Le(s) produit(s) a(ont) été ajouté(s) et le stock modifié.');
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
		$operation = $request->request->get('operation');
		$valeur = $request->request->get('valeur');

		$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Produits');
        $produit = $repository->getProduitParId($id);

		//cas de l'ajout de produits
		if( $operation == '+'){

			for ($i = 0; $i < $valeur; $i++) 
			{
				$stock = new Stock();

				$stock->setDateEntree(new \DateTime());
				$stock->setProduit($produit);

				$em->persist($stock);
			}
		}
		//cas de la suppression de produits
		else if( $operation == '-'){
			$repository = $em->getRepository('AppBundle:Stock');
			$lignes = $repository->getLigneASupprimer($valeur, $id);

			foreach ($lignes as $val){
				$val->setDateSortie(new \DateTime());
				$val->setBitSup(1);

				$em->persist($val);
			}
		}

		//pour le prix du produit
		$produit->setPrixProduit($prix);
		$em->persist($produit);

		$em->flush();

		$request->getSession()->getFlashBag()->add('notice', 'Le stock a été modifié.');

		return $this->render('AppBundle:Stock:flash.html.twig');
	}

	public function lignesProduitAction(Request $request){

		//si demande ajax
        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Stock');

            $lignes = $repository->getLignesParId($id);
            
        	return $this->render('AppBundle:Stock:lignesajax.html.twig', array('lignes' => $lignes));
        }
	}

	public function nomenclatureAction(Request $request){

        //Récupération de la liste des produits plastprod pour ajouter ou modifier les nomenclatures
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Produits');

        $listenomenclature = $repository->getListeProduitsInterne();

        //Mise en forme pour utilisation de la liste de produits en javascript
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        /***************************************************************/

        // On crée un objet commande
        $commande = new Nomenclature();

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(new CommandeType(), $commande);

        if ($form->handleRequest($request)->isValid()) 
        {
          // On l'enregistre notre objet $commande dans la base de données.
          $em = $this->getDoctrine()->getManager();
          
          $em->persist($commande);

          foreach ($commande->getProduits()->toArray() as $commandeproduits) {
            $commandeproduits->setCommande($commande);
            $em->persist($commandeproduits);
          }
             
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregistrée.');

          // On redirige vers la page de visualisation de la commande nouvellement créée
          return $this->redirect($this->generateUrl('ajouter_commande'));
        }

        $jslisteproduits = $serializer->serialize($listeproduits, 'json');
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:Client:addorder.html.twig', array(
          'form' => $form->createView(), 'listeproduits' => $listeproduits, 'jslisteproduits' => $jslisteproduits
        ));		
	}
}